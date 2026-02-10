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
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->route('category')) {
                        $category = $request->route('category');
                        if ($value == $category->id) {
                            $fail('Không thể chọn chính danh mục này làm danh mục cha.');
                        }
                        if (in_array($value, $category->getDescendantIds())) {
                            $fail('Không thể chọn danh mục con làm danh mục cha.');
                        }
                    }
                },
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category_images', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Tạo danh mục thành công!');
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
