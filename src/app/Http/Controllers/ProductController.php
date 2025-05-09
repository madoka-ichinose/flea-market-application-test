<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Category;

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

    if (auth()->check()) {
        $productsQuery->where('user_id', '!=', auth()->id());
    }

    $products = $productsQuery->latest()->get();

    $favorites = auth()->check()
        ? Favorite::with('product')
            ->where('user_id', auth()->id())
            ->whereHas('product', function ($query) use ($keyword) {
                if ($keyword) {
                    $query->where('product_name', 'like', '%' . $keyword . '%');
                }
            })
            ->get()
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

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image',
            'categories' => 'required|string',
            'condition' => 'required|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い',
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
        ]);

        $path = $request->file('image')->store('images', 'public');

        $product = Product::create([
        'image' => $path,
        'condition' => $validated['condition'],
        'product_name' => $validated['product_name'],
        'brand' => $validated['brand'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'user_id' => auth()->id(),
        ]);

        $categoryIds = explode(',', $validated['categories']);
        $product->categories()->attach($categoryIds);

        return redirect()->route('mypage')->with('success', '商品が出品されました');
    }
}
