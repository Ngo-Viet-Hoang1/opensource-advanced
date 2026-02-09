<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::root()->with('childrenRecursive')->get();

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::root()->with('childrenRecursive')->get();

        return view('admin.categories.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ],);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category_images', 'public');
            $validated['image'] = $path;
        }

        Category::create($validated);
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
