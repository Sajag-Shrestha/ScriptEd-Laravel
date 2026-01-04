<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    // Admin Module Controller

    public function index()
    {
        $modules = Module::all();
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.modules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $imageName = time() . '.' . $request->icon->extension();
        $request->icon->move(public_path('uploads/Module_Icon'), $imageName);
        $iconPath = 'uploads/Module_Icon/' . $imageName;

        Module::create([
            'name' => $request->name,
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Module created successfully.');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        if ($request->hasFile('icon')) {
            if (!empty($module->icon) && file_exists(public_path($module->icon))) {
                unlink(public_path($module->icon));
            }

            $imageName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/Module_Icon'), $imageName);
            $module->icon = 'uploads/Module_Icon/' . $imageName;
        }

        $module->name = $request->name;
        $module->save();

        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully.');
    }

    public function delete($id)
    {
        $module = Module::findOrFail($id);

        if (!empty($module->icon) && file_exists(public_path($module->icon))) {
            unlink(public_path($module->icon));
        }

        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully.');
    }

    // Student Module Controller
    public function show()
    {
        $modules = Module::withCount('courses')->get();

        return view('student.modules', compact('modules'));
    }

    public function detail($id)
    {
        $module = Module::with(['courses'=> function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);

        $library = null;

        if (Auth::check()) {
            $library = Library::where('user_id', Auth::id())
                ->where('module_id', $id)
                ->first();
        }

        return view('student.module-detail', compact('module', 'library'));
    }
}
