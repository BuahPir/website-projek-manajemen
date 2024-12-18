<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskActivityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
});

// Project routes
Route::resource('projects', ProjectController::class);

// Nested task routes within a project
Route::prefix('projects/{projectId}')->middleware('auth')->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('tasks/store', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('tasks/{taskId}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::put('tasks/{taskId}', [TaskController::class, 'update'])->name('projects.tasks.update');
    Route::delete('tasks/{taskId}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');
    Route::patch('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('projects.tasks.updateStatus');
    Route::post('tasks/{taskId}/storeActivity', [TaskActivityController::class, 'store'])->name('projects.tasks.activities.store');
    Route::post('tasks/{taskId}/addComment', [CommentController::class, 'store'])->name('projects.tasks.comments.store');
    Route::get('tasks/{taskId}/download/{fileName}', [TaskActivityController::class, 'download'])->name('projects.tasks.file.download');

});

Route::get('/notifications/mark-all-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.markAllAsRead');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::prefix('admin')->middleware(['auth','adminMiddleware' => \App\Http\Middleware\RoleMiddleware::class])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/teams', [TeamController::class, 'indexAdmin'])->name('admin.teams.index'); // Add middleware if needed
    Route::delete('/teams/{id}', [TeamController::class, 'destroyAdmin'])->name('admin.teams.destroy');
    Route::get('/projects', [ProjectController::class, 'indexAdmin'])->name('admin.projects.index');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroyAdmin'])->name('admin.projects.destroy'); // Add middleware if needed
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

// Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


// Resend Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/coba', function () {
    return view('coba');
});

require __DIR__.'/auth.php';
