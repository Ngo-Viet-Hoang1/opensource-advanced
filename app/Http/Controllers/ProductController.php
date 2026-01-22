<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Products';
        $products = [
            ['id' => 1, 'name' => 'Product A', 'price' => '5000$'],
            ['id' => 2, 'name' => 'Product B', 'price' => '6000$'],
            ['id' => 3, 'name' => 'Product C', 'price' => '7000$'],
        ];

        return view('product.index', ['title' => $title, 'products' => $products]);
    }

    public function create()
    {
        return view('product.add');
    }

    public function store(Request $request)
    {
        $csrfToken = csrf_token();
        return $request->all();
    }

    public function detail(string $id = '123')
    {
        return view('product.detail', ['id' => $id]);
    }
}
