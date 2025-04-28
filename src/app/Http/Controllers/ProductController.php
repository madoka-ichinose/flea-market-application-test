<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $tab = $request->get('tab', 'product');

    $keyword = $request->get('keyword');
    $productsQuery = Product::query();

    if ($keyword) {
        $productsQuery->where('product_name', 'like', '%' . $keyword . '%');
    }

    $products = $productsQuery->latest()->get();

    $favorites = auth()->check()
        ? Favorite::with('product')->where('user_id', auth()->id())->get()
        : collect();

    return view('index', compact('products', 'favorites', 'tab'));
    }

    public function show($product_id)
    {
        $product = Product::with(['categories', 'comments.user'])  
                      ->findOrFail($product_id);  

        $product->favorites_count = $product->favorites->count();
        $product->comments_count = $product->comments->count();

        return view('item', compact('product'));
    }
}
