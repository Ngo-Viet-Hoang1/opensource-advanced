<?php

namespace App\Http\Controllers;

use App\Models\Product;

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
}
