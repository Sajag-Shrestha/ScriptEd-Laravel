<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RoleRequestController;
use App\Models\Achievement;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('auth.login');
})->name('user.login');

Route::get('/registration', function () {
    return view('auth.register');
})->name('user.register');

// Verification

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

// Student Route

Route::middleware(['auth', 'CheckRole:Student'])->group(function () {

    // Dashboard Route
    Route::get('student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');

    // Module Route
    Route::get('student/modules', [ModuleController::class, 'show'])->name('student.modules');
    Route::get('student/module-detail/{id}', [ModuleController::class, 'detail'])->name('student.module-detail');

    // Course Route
    Route::get('student/course/{id}', [CourseController::class, 'scrape'])->name('student.course');
    
    // Progress Route
    Route::get('student/progress', [AchievementController::class, 'progress'])->name('student.progress');

    // Library Route
    Route::get('student/library', [LibraryController::class, 'show'])->name('library.show');
    Route::post('/library/add/{id}', [LibraryController::class, 'add'])->name('library.add');
    Route::patch('/library/remove/{id}', [LibraryController::class, 'remove'])->name('library.remove');
    Route::post('library/track', [LibraryController::class, 'track'])->name('library.track');
     
    // Request Route
    Route::post('/request-teacher', [RoleRequestController::class, 'store'])->name('request.teacher');

    // Quiz Routes
    Route::get('student/quiz', [QuizController::class, 'quizList'])->name('student.quizList');
    Route::get('student/quiz/{quiz}', [QuizController::class, 'quizAttempt'])->name('student.quizAttempt');
    Route::post('student/quiz/{quiz}/submit', [QuizController::class, 'quizSubmit'])->name('student.quizSubmit');

    

});

// Teacher Route

Route::middleware(['auth', 'CheckRole:Teacher'])->group(function () {

    Route::get('teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');

    Route::get('quizzes/create', [QuizController::class, 'create'])->name('teacher.quizzes.create');
    Route::get('quizzes/index', [QuizController::class, 'index'])->name('teacher.quizzes.index');
    Route::post('quizzes/index', [QuizController::class, 'store'])->name('teacher.quizzes.store');
    Route::get('quizzes/{id}/edit', [QuizController::class, 'edit'])->name('teacher.quizzes.edit');
    Route::put('quizzes/{id}', [QuizController::class, 'update'])->name('teacher.quizzes.update');
    Route::delete('quizzes/{id}', [QuizController::class, 'delete'])->name('teacher.quizzes.delete');
    
    Route::get('teacher/tracking', [UserController::class, 'track'])->name('teacher.tracking');
    Route::get('teacher/tracking/{id}', [UserController::class, 'showReport'])->name('teacher.report');
    



});


// Admin Route

Route::middleware(['auth', 'CheckRole:Admin'])->group(function () {

    // Dashboard Routes
    Route::get('admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    
    // User Routes
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('admin/users/index', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
    
    // Module Routes
    Route::get('admin/modules/create', [ModuleController::class, 'create'])->name('admin.modules.create');
    Route::get('admin/modules/index', [ModuleController::class, 'index'])->name('admin.modules.index');
    Route::post('admin/modules/index', [ModuleController::class, 'store'])->name('admin.modules.store');
    Route::get('admin/modules/{id}/edit', [ModuleController::class, 'edit'])->name('admin.modules.edit');
    Route::put('admin/modules/{id}', [ModuleController::class, 'update'])->name('admin.modules.update');
    Route::delete('admin/modules/{id}', [ModuleController::class, 'delete'])->name('admin.modules.delete');

    // Course Routes
    Route::get('admin/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');
    Route::get('admin/courses/index', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::post('admin/courses/index', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::get('admin/courses/{id}/view', [CourseController::class, 'show'])->name('admin.courses.view');
    Route::get('admin/courses/{id}/edit', [CourseController::class, 'edit'])->name('admin.courses.edit');
    Route::put('admin/courses/{id}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('admin/courses/{id}', [CourseController::class, 'delete'])->name('admin.courses.delete');

    // Role Request Routes
    Route::get('role-requests', [RoleRequestController::class, 'index'])->name('admin.role-requests.index');
    Route::post('role-requests/{id}/approve', [RoleRequestController::class, 'approve'])->name('admin.role-requests.approve');
    Route::post('role-requests/{id}/reject', [RoleRequestController::class, 'reject'])->name('admin.role-requests.reject');
    Route::post('/admin/role-requests/{id}/revaluate', [RoleRequestController::class, 'revaluate'])->name('admin.role-requests.revaluate');
    Route::post('/admin/role-requests/{id}/revert', [RoleRequestController::class, 'revert'])->name('admin.role-requests.revert');

    // Achievement Routes
    Route::get('admin/achievements/create', [AchievementController::class, 'create'])->name('admin.achievements.create');
    Route::get('admin/achievements/index', [AchievementController::class, 'index'])->name('admin.achievements.index');
    Route::post('admin/achievements/index', [AchievementController::class, 'store'])->name('admin.achievements.store');
    Route::get('admin/achievements/{id}/edit', [AchievementController::class, 'edit'])->name('admin.achievements.edit');
    Route::put('admin/achievements/{id}', [AchievementController::class, 'update'])->name('admin.achievements.update');
    Route::delete('admin/achievements/{id}', [AchievementController::class, 'delete'])->name('admin.achievements.delete');

    // Rank Routes
    Route::get('admin/ranks/create', [RankController::class, 'create'])->name('admin.ranks.create');
    Route::get('admin/ranks/index', [RankController::class, 'index'])->name('admin.ranks.index');
    Route::post('admin/ranks/index', [RankController::class, 'store'])->name('admin.ranks.store');
    Route::get('admin/ranks/{id}/edit', [RankController::class, 'edit'])->name('admin.ranks.edit');
    Route::put('admin/ranks/{id}', [RankController::class, 'update'])->name('admin.ranks.update');
    Route::delete('admin/ranks/{id}', [RankController::class, 'delete'])->name('admin.ranks.delete');


});

// Auth Route

 Route::get("auth/google", [GoogleController::class, "redirectToGoogle"])->name("redirect.google");
 Route::get("auth/google/callback", [GoogleController::class, "handleGoogleCallback"]);



Route::middleware('auth')->group(function () {
    Route::get('/user-profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/affiliations/search', [ProfileController::class, 'search'])->name('affiliations.search');
    Route::post('/affiliations/add', [ProfileController::class, 'add'])->name('affiliations.add');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/settings/profile', [ProfileController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password');
    Route::delete('/settings/delete', [ProfileController::class, 'destroy'])->name('settings.delete');
});

require __DIR__.'/auth.php';
