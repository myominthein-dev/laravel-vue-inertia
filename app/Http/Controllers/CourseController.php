<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\SubscribedCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category','user'])->get();
        
        return Inertia::render('Course/Index', [
            'courses' => $courses,
        ]);
    }

    public function create () {
        Gate::authorize('create', Course::class);
        $categories = Category::all();
        
        return Inertia::render('Course/Create', ['categories' => $categories]);
    }

    public function store (Request $request) {
        $user_id = Auth::id();
        $request->validate([
            'title' => 'required|string|max:255|unique:courses',
            'description' => 'string|max:255',
            'slug' => 'required|string|max:255|unique:courses',
            'category_id' => 'required'
        ]);

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'user_id' => $user_id
        ]);

        return redirect()->route('course.create');
    }

    public function edit (Course $course) {

        $categories = Category::all();
        return Inertia::render('Course/Edit', [
            'course' => $course,
            'categories' => $categories
        ]);
    }

    public function update (Request $request, Course $course)  {
        $request->validate([
            'title' => [
                'required', Rule::unique('courses')->ignore($course->id)
            ],
            'slug' => ['required','string','max:255',
                Rule::unique('courses')->ignore($course->id)
            ],
            'description' => 'nullable|string|max:255',
            'category_id' => 'required'
        ]);

        $course->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('course');
    }

    public function destroy (Course $course) {

        Gate::authorize('delete', $course);

        $course->delete();

        return redirect()->back();
    }

    public function subscribe ($id) {
        $userId = Auth::id();

        $isExisted = SubscribedCourse::where('course_id', $id)->where('user_id',$userId)->first();

        if ($isExisted) {
            $isExisted->delete();
        } else {
            SubscribedCourse::create([
            'user_id' => $userId,
            'course_id' => $id    
        ]);
        }
        
        return redirect()->back();
    }

    public function subscribedCourses () {
        $subscribedCourseIds = SubscribedCourse::where('user_id', Auth::id())->pluck('course_id')->toArray();
        return Inertia::render('SubscribedCourse/Index',['subscribedCourseIds' => $subscribedCourseIds]);
    }
}
