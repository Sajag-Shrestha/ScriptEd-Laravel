<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    // Admin Course Controller:


    public function index(Request $request)
    {
        $moduleId = $request->query('module');

        if ($moduleId && $moduleId !== 'all') {
            
            $modules = Module::with(['courses' => function ($query) {
                $query->orderBy('order');
            }])->where('id', $moduleId)->get();
        } else {
           
            $modules = Module::with(['courses' => function ($query) {
                $query->orderBy('order');
            }])->get();
        }

        return view('admin.courses.index', compact('modules', 'moduleId'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('admin.courses.create', compact('modules'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'source' => 'required|max:255',
            'type' => 'required|in:Video,Documentation,Structured Course',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'url' => 'required|max:255',
            'order' => 'nullable|integer|min:0|unique:courses,order,NULL,id,module_id,' . $request->module_id,
        ]);

        Course::create([
            'module_id' => $request->module_id,
            'title' => $request->title,
            'description' => $request->description,
            'source' => $request->source,
            'type' => $request->type,
            'difficulty_level' => $request->difficulty_level,
            'url' => $request->url,
            'order' => $request->order ?? 0,
        ]);


        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully');
    }


    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        $modules = Module::all();
        return view('admin.courses.view', compact('course', 'modules'));
    }


    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $modules = Module::all();
        return view('admin.courses.edit', compact('course', 'modules'));
    }


    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'source' => 'required|max:255',
            'type' => 'required|in:Video,Documentation,Structured Course',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'url' => 'required|max:255',
            'order' => 'nullable|integer|min:0|unique:courses,order,' . $course->id . ',id,module_id,' . $request->module_id,
        ]);


        $course->update([
            'module_id' => $request->module_id,
            'title' => $request->title,
            'description' => $request->description,
            'source' => $request->source,
            'type' => $request->type,
            'difficulty_level' => $request->difficulty_level,
            'url' => $request->url,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }


    public function delete(string $id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    public function scrape($id)
    {
        $course = Course::with('module')->findOrFail($id);

        $nextCourse = Course::where('module_id', $course->module_id)
            ->where('order', '>', $course->order)
            ->orderBy('order')
            ->first();

        $previousCourse = Course::where('module_id', $course->module_id)
            ->where('order', '<', $course->order)
            ->orderByDesc('order')
            ->first();

        try {
            $response = Http::timeout(5)->get($course->url);
            $html = $response->body();
            $crawler = new Crawler($html, $course->url);
            $baseUri = new Uri($course->url);

            // Title
            $course->scraped_title = $crawler->filter('title')->text();

            // Scraping logic
            $contentHtml = '';
            if ($course->source === 'Python Docs') {
                $sectionId = Str::slug($course->title);
                $node = $crawler->filter("section#$sectionId");
                $contentHtml = $node->count() ? $node->html() : '<p>Section not found.</p>';
            } elseif ($course->source === 'MDN Web Docs') {
                $node = $crawler->filter('#content > article');
                $contentHtml = $node->count() ? $node->html() : '<p>Article not found.</p>';
            } elseif ($course->source === 'Laravel Docs') {
                $node = $crawler->filter('#main-content');
                $contentHtml = $node->count() ? $node->html() : '<p>Main content not found.</p>';
            } else {
                $node = $crawler->filter('body');
                $contentHtml = $node->count() ? $node->html() : $html;
            }

            // Fix relative links
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($contentHtml, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();

            $tagsToFix = ['a' => 'href', 'img' => 'src'];
            foreach ($tagsToFix as $tag => $attr) {
                foreach ($dom->getElementsByTagName($tag) as $element) {
                    $original = $element->getAttribute($attr);
                    if (!$original) continue;
                    $resolved = UriResolver::resolve($baseUri, new Uri($original));
                    $element->setAttribute($attr, (string) $resolved);
                }
            }

            $body = $dom->getElementsByTagName('body')->item(0);
            $innerHTML = '';
            foreach ($body->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }

            $course->scraped_html = $innerHTML;
        } catch (\Exception $e) {
            $course->scraped_title = 'Failed to scrape';
            $course->scraped_html = '<p>Could not load content.</p>';
        }

        return view('student.course', compact('course', 'previousCourse', 'nextCourse'));
    }
}
