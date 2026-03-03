<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
/* class ProductController extends Controller implements HasMiddleware */
{
    /* public static function middleware() */
    /* { */
    /*     return [CheckTimeAccess::class,]; */
    /* } */

    public function index(Request $request)
    {
        $title = 'Products';

        $query = Product::with('category');

        if ($request->filled('search')) {
            $query = $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query = $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.product.index', compact('title', 'products'));
    }

    public function create()
    {
        $title = 'Add Product';
        $categories = Category::all();

        return view('admin.product.add', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if (!isset($validated['image'])) {
            $validated['image'] = 'https://picsum.photos/seed/123abc/800/600';
        }

        Product::create($validated);

        return to_route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $title = 'Edit Product';
        $categories = Category::all();

        return view('admin.product.edit', compact('title', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'is_active'   => 'boolean',
        ]);


        $product->update($validated);

        return to_route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('products.index')->with('success', 'Product deleted successfully.');
    }
}
