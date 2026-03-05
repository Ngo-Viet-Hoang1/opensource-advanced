<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        $query->orderBy('id', 'desc');

        $categories = $query->paginate(10);

        $totalCategories = Category::count();

        return view('admin.categories.index', compact('categories', 'totalCategories'));
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
        $category->load('parent', 'children');

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $excludeIds = array_merge(
            [$category->id],
            $category->getDescendantIds()
        );

        $parentCategories = Category::with('childrenRecursive')
            ->whereNull('parent_id')
            ->get();

        return view('admin.categories.edit', compact(
            'category',
            'parentCategories',
            'excludeIds'
        ));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
            ],
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
            Storage::disk('public')->delete($category->image);
            $path = $request->file('image')->store('category_images', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Không thể xóa danh mục có danh mục con!');
        }

        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Không thể xóa danh mục có sản phẩm!');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
