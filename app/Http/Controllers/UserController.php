<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:Student,Teacher,Admin'], // Validate role input
        ]);

        $profileImage = match ($request->role) {
            'Admin' => 'uploads/admin.png',
            'Student' => 'uploads/student.png',
            'Teacher' => 'uploads/teacher.png',
        };

        // Create the user with the provided data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Assign the role
            'profile_image' => $profileImage, // Assign profile image based on role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:Student,Teacher,Admin',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function track()
    {
        $teacher = Auth::user();

        $students = $teacher->affiliatedStudents()->orderBy('name')->get();

        return view('teacher.tracking', compact('students'));
    }

    public function showReport($id)
    {
        $user = User::with('rank')->findOrFail($id);

        // Library progress (module tracking)
        $libraryItems = Library::where('user_id', $user->id)
            ->with('module.courses')
            ->get();

        $totalModules = $libraryItems->count();
        $completedModules = $libraryItems->where('status', 'completed')->count();
        $inProgressModules = $libraryItems->where('status', 'in_progress')->count();

        // Time spent
        $totalTimeSpent = $libraryItems->sum('time_spent');
        $hours = floor($totalTimeSpent / 60);
        $minutes = $totalTimeSpent % 60;
        $timeSpentFormatted = "{$hours}h {$minutes}m";

        // Achievements
        $achievements = UserAchievement::where('user_id', $user->id)
            ->whereNotNull('earned_at')
            ->with('achievement')
            ->get();

        // Quizzes
        $quizzes = QuizAttempt::where('student_id', $user->id)
            ->with(['quiz' => fn($q) => $q->with('teacher')])
            ->orderBy('finished_at', 'desc')
            ->get();

        return view('teacher.report', compact(
            'user',
            'libraryItems',
            'totalModules',
            'completedModules',
            'inProgressModules',
            'timeSpentFormatted',
            'achievements',
            'quizzes'
        ));
    }
}
