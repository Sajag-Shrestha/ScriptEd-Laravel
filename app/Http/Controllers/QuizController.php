<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuizAttempt;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // Teacher Quiz Controller

    public function index()
    {
        $quizzes = Quiz::withCount('questions')->where('teacher_id', Auth::id())->get();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('teacher.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:1',
            'questions.*.options.*.option_text' => 'required|string',
        ]);

        foreach ($request->questions as $qIndex => $questionData) {
            $hasCorrect = false;
            foreach ($questionData['options'] as $optionData) {
                if (isset($optionData['is_correct'])) {
                    $hasCorrect = true;
                    break;
                }
            }

            if (!$hasCorrect) {
                return back()->withErrors([
                    "questions.{$qIndex}" => "Question " . ($qIndex + 1) . " must have at least one correct answer."
                ])->withInput();
            }
        }

        $quiz = Quiz::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description
        ]);

        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text']
            ]);

            foreach ($questionData['options'] as $optionData) {
                $question->answers()->create([
                    'answer_text' => $optionData['option_text'],
                    'is_correct' => isset($optionData['is_correct']) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz created successfully.');
    }


    public function edit($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return view('teacher.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:1',
            'questions.*.options.*.option_text' => 'required|string',
        ]);

        foreach ($request->questions as $qIndex => $questionData) {
            $hasCorrect = false;
            foreach ($questionData['options'] as $optionData) {
                if (isset($optionData['is_correct'])) {
                    $hasCorrect = true;
                    break;
                }
            }

            if (! $hasCorrect) {
                return back()->withErrors([
                    "questions.{$qIndex}" => "Question " . ($qIndex + 1) . " must have at least one correct answer."
                ])->withInput();
            }
        }

        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        // Optional: auth check
        if ($quiz->teacher_id !== Auth::id()) {
            abort(403);
        }

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Remove old questions and answers
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question_text' => $questionData['question_text']
            ]);

            foreach ($questionData['options'] as $optionData) {
                $question->answers()->create([
                    'answer_text' => $optionData['option_text'],
                    'is_correct' => isset($optionData['is_correct']) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz updated successfully.');
    }


    public function delete($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    // Student Quiz Controller

    public function quizList()
    {
        $student = Auth::user();

        $teacherIds = $student->affiliatedTeachers()->select('users.id')->pluck('users.id');

        // Get quizzes only from affiliated teachers
        $quizzes = Quiz::with('teacher', 'questions')
            ->withCount('questions')
            ->whereIn('teacher_id', $teacherIds)
            ->get()
            ->map(function ($quiz) use ($student) {
                $attempt = $quiz->attempts()
                    ->where('student_id', $student->id)
                    ->first();

                $quiz->attempted = $attempt ? true : false;
                $quiz->score = $attempt?->score;

                return $quiz;
            });

        return view('student.quiz-list', compact('quizzes'));
    }

    public function quizAttempt($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $user = Auth::user();

        $existing = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('student.quizList')->with('error', 'You have already attempted this quiz.');
        }

        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $user->id,
            'started_at' => now(),
        ]);

        return view('student.quiz-attempt', compact('quiz'));
    }


    public function quizSubmit(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $user->id)
            ->whereNull('finished_at')
            ->latest()
            ->first();

        if (!$attempt) {
            return back()->with('error', 'No active quiz attempt found.');
        }

        $score = 0;

        foreach ($request->input('answers', []) as $questionId => $answerId) {
            $isCorrect = Answer::where('id', $answerId)
                ->where('question_id', $questionId)
                ->where('is_correct', true)
                ->exists();

            if ($isCorrect) {
                $score++;
            }

            QuizResponse::create([
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'answer_id' => $answerId,
            ]);
        }

        $attempt->update([
            'score' => $score,
            'finished_at' => now(),
        ]);

        return redirect()->route('student.quizList')->with('success', 'Quiz submitted successfully!');
    }
}
