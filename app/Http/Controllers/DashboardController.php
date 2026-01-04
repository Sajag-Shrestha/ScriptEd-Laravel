<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\Course;
use App\Models\Library;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Models\Affiliation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function student()
    {
        $user = Auth::user();

        // Get user's library data
        $libraryItems = Library::where('user_id', $user->id)
            ->with(['module'])
            ->get();

        // Calculate courses statistics
        $totalCourses = $libraryItems->count();
        $completedCourses = $libraryItems->where('status', 'completed')->count();

        // Get user's connections (affiliations)
        $connections = $user->affiliatedTeachers()->count();
        $pendingConnections = 1;

        // Calculate time spent
        $totalTimeSpent = $libraryItems->sum('time_spent');
        $hours = floor($totalTimeSpent / 60);
        $minutes = $totalTimeSpent % 60;
        $timeSpentFormatted = "{$hours}h {$minutes}m";

        // Compare with last week's time
        $lastWeekTimeSpent = Library::where('user_id', $user->id)
            ->where('last_opened', '>=', Carbon::now()->subWeek())
            ->where('last_opened', '<', Carbon::now())
            ->sum('time_spent');

        // Calculate percentage change (avoid division by zero)
        $timeChangePercentage = 0;
        if ($lastWeekTimeSpent > 0) {
            $previousWeekTimeSpent = Library::where('user_id', $user->id)
                ->where('last_opened', '>=', Carbon::now()->subWeeks(2))
                ->where('last_opened', '<', Carbon::now()->subWeek())
                ->sum('time_spent');

            if ($previousWeekTimeSpent > 0) {
                $timeChangePercentage = round((($lastWeekTimeSpent - $previousWeekTimeSpent) / $previousWeekTimeSpent) * 100);
            }
        }

        // Get in-progress courses with detailed info
        $inProgressCourses = Library::with(['module' => fn($q) => $q->with('courses')])
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->orderByDesc('last_opened')
            ->take(5)
            ->get()
            ->map(function ($lib) {
                $lib->progress = max(0, min(100, $lib->progress));
                return $lib;
            });

        // Performance stats
        $completedPercentage = ($totalCourses > 0) ? round(($completedCourses / $totalCourses) * 100) : 0;
        $inProgressPercentage = ($totalCourses > 0) ? 100 - $completedPercentage : 0;

        // Get quizzes for student

        $teacherIds = $user->affiliatedTeachers()->select('users.id')->pluck('users.id');

        $quizzes = Quiz::with(['teacher', 'questions'])
            ->withCount('questions')
            ->whereIn('teacher_id', $teacherIds)
            ->get()
            ->map(function ($quiz) use ($user) {
                $attempt = $quiz->attempts()
                    ->where('student_id', $user->id)
                    ->latest()
                    ->first();

                $quiz->attempted = (bool) $attempt;
                $quiz->score = $attempt?->score;
                $quiz->last_attempt = $attempt?->finished_at;

                return $quiz;
            });

        return view('student.dashboard', compact(
            'user',
            'totalCourses',
            'completedCourses',
            'connections',
            'pendingConnections',
            'timeSpentFormatted',
            'timeChangePercentage',
            'inProgressCourses',
            'completedPercentage',
            'inProgressPercentage',
            'quizzes'
        ));
    }

    public function teacher()
    {
        $teacher = Auth::user();

        // Total quizzes created by the teacher
        $totalQuizzes = Quiz::where('teacher_id', $teacher->id)->count();

        // Total attempts across all quizzes
        $totalAttempts = QuizAttempt::whereHas('quiz', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->count();

        // Total affiliated students
        $totalStudents = $teacher->affiliatedStudents()->count();

        // Pending affiliation requests
        $pendingAffiliations = 1;

        // Recent quizzes (last 5 quizzes created)
        $recentQuizzes = Quiz::where('teacher_id', $teacher->id)
            ->withCount('attempts')
            ->latest()
            ->take(5)
            ->get();

        // Performance stats for chart
        $completedAttempts = QuizAttempt::whereHas('quiz', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
            ->whereNotNull('finished_at')
            ->count();

        $inProgressAttempts = $totalAttempts - $completedAttempts;

        $total = $completedAttempts + $inProgressAttempts;
        $completedPercentage = $total > 0 ? round(($completedAttempts / $total) * 100) : 0;
        $inProgressPercentage = $total > 0 ? round(($inProgressAttempts / $total) * 100) : 0;

        // Time spent (total time students spent on modules from libraries table)
        $timeSpentSeconds = QuizAttempt::whereHas('quiz', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
            ->whereNotNull('finished_at')
            ->whereNotNull('started_at')
            ->whereRaw('finished_at >= started_at')
            ->sum(\DB::raw('TIMESTAMPDIFF(SECOND, started_at, finished_at)'));

        $timeSpentFormatted = gmdate('H:i:s', max(0, $timeSpentSeconds));

        // Time change percentage (this week vs last week)

        $timeChangePercentage = 37;

        return view('teacher.dashboard', compact(
            'totalQuizzes',
            'totalAttempts',
            'totalStudents',
            'pendingAffiliations',
            'recentQuizzes',
            'completedPercentage',
            'inProgressPercentage',
            'timeSpentFormatted',
            'timeChangePercentage'
        ));
    }

    public function admin()
    {
        $users = User::all();
        $userCount = User::count();

        $courses = Course::latest()->take(5)->get();
        $courseCount = Course::count();

        $moduleCount = Module::count();

        $achievementCount = Achievement::count();

        return view('admin.dashboard', compact(
            'users',
            'userCount',
            'courses',
            'courseCount',
            'moduleCount',
            'achievementCount'
        ));
    }
}
