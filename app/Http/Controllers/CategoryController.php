<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;


class CategoryController extends Controller
{
   use AuthorizesRequests;
   
    public function index () {
        $categories = Category::all();
        return Inertia::render('Category/Index', [
            "categories" => $categories
        ]);

    }

    public function show(Category $category) {
        return Inertia::render('Category/Show', [
            'category' => $category
        ]);
    }

    public function create () {
        Gate::authorize('create', Category::class);
        return Inertia::render('Category/Create');
    }   

    public function store (Request $request) {

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->back();
    }

   public function edit(Category $category) {
    return Inertia::render('Category/Edit', [
        'category' => $category
    ]);
}


    public function update (Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('category');
    }
    
    public function destroy (Category $category) {
        Gate::authorize('delete', $category);

        $category->delete();

        return redirect()->back();
    }
}
