<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use App\Models\SubscribedCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $courses = Course::all();
    $subscribedCourseIds = SubscribedCourse::where('user_id', Auth::id())->pluck('course_id')->toArray();
    return Inertia::render('Welcome',['courses' => $courses,'subscribedCourseIds' => $subscribedCourseIds]);
})->name('home');



Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified','role:Super Admin|Admin'])->name('dashboard');

Route::resource('course', CourseController::class)
    ->middleware(['auth', 'verified', 'role:Super Admin|Admin'])
    ->names(['index' => 'course.view','create' => 'course.create','edit' => 'course.edit', 'update' => 'course.update','destroy' => 'course.destroy']);

Route::resource('user', UserController::class)
    ->middleware(['auth', 'verified','role:Super Admin|Admin|User'])
    ->names(['index' => 'user']);

Route::resource('category', CategoryController::class)
    ->middleware(['auth', 'verified','role:Super Admin|Admin'])
    ->names(['index' => 'category', 'create' => 'category.create','store' => 'category.store', 'edit' => 'category.edit', 'update' => 'category.update', 'destroy' => 'category.destroy']);

// Admin routes with role middleware
Route::middleware(['auth', 'role:Super Admin|Admin'])->prefix('admin')->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::post('course/{id}/subscribe',[CourseController::class, 'subscribe'])
    ->middleware(['auth', 'verified','role:User'])
    ->name('course.subscribe');

Route::get('saved-courses', [CourseController::class,'subscribedCourses']);
require __DIR__.'/settings.php';    
require __DIR__.'/auth.php';
