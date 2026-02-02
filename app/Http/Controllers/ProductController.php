<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckTimeAccess;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductController extends Controller
/* class ProductController extends Controller implements HasMiddleware */
{
    /* public static function middleware() */
    /* { */
    /*     return [CheckTimeAccess::class,]; */
    /* } */

    public function index()
    {
        $title = 'Products';

        $products = Product::all();

        return view('product.index', ['title' => $title, 'products' => $products]);
    }

    public function create()
    {
        return view('product.add');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');

        $product->save();

        return redirect('/product');
    }

    public function detail(string $id = '123')
    {
        return view('product.detail', ['id' => $id]);
    }

    public function edit(Product $product)
    {
        return view('product.edit', ['product' => $product]);
    }

    public function update(Product $product)
    {
        $name = request()->get('name');
        $price = request()->get('price');
        $stock = request()->get('stock');
        $product->update([
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
        ]);

        return redirect('product');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('product');
    }
}
