<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AchievementController;

class LibraryController extends Controller
{
    // Student Library Controller

    public function add($moduleId)
    {
        $user = Auth::user();

        $library = Library::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $moduleId],
            ['is_in_library' => true, 'date_added' => now()]
        );

        // Re-enable if previously removed
        if (!$library->is_in_library) {
            $library->is_in_library = true;
            $library->save();
        }

        return back()->with('success', 'Module added to library.');
    }

    public function remove($moduleId)
    {
        $user = Auth::user();

        $library = Library::where('user_id', $user->id)
            ->where('module_id', $moduleId)
            ->first();

        if ($library) {
            $library->is_in_library = false;
            $library->save();
        }

        return back()->with('success', 'Module removed from library.');
    }

    public function track(Request $request)
    {
        $data = $request->validate([
            'module_id'  => 'required|integer|exists:modules,id',
            'course_id'  => 'required|integer|exists:courses,id',
            'time_spent' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        // Find or create the library record -  default is_in_library to false
        $library = Library::firstOrCreate(
            [
                'user_id'   => $user->id,
                'module_id' => $data['module_id'],
            ],
            [
                'date_added'    => now(),
                'is_in_library' => false,
                'last_opened'   => now(),
                'time_spent'    => 0,
                'progress'      => 0,
                'status'        => 'in_progress',
            ]
        );

        // Update only the tracking fields:
        $library->last_opened  = now();
        $library->time_spent  += $data['time_spent'];

        // Recalculating progress
        $module = $library->module;
        $total  = $module->courses()->count() ?: 1;
        
        $course = $module->courses()->find($data['course_id']);

        // Safety: if the course belongs to the module
        if ($course) {
            $currentOrder = $course->order;
            $percent      = ($currentOrder / $total) * 100;
            $newProgress  = min(100, round($percent, 2));

            // Only update progress if it increases
            if ($newProgress > $library->progress) {
                $library->progress = $newProgress;
                $library->status   = $newProgress >= 100 ? 'completed' : 'in_progress';
            }
        }

        $library->save();

        app(AchievementController::class)->handleAchievementsAndRank($user);

        return response()->json(['message' => 'Progress tracked']);
    }


    public function show()
    {
        $user = Auth::user();
        $modules   = Module::withCount('courses')->get();
        $libraries = Library::with('module')
            ->where('user_id', $user->id)
            ->get();
        return view('student.library', compact('modules', 'libraries'));
    }
}
