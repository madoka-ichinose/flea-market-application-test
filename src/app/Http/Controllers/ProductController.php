<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Category;
use App\Http\Requests\SellRequest;

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

   public function store(SellRequest $request)
{
    $validated = $request->validated();

    $path = $request->file('image')->store('images', 'public');

    $product = Product::create([
        'image'        => $path,
        'condition'    => $validated['condition'],
        'product_name' => $validated['product_name'],
        'brand'        => $validated['brand'] ?? null,
        'description'  => $validated['description'],
        'price'        => $validated['price'],
        'user_id'      => auth()->id(),
    ]);

    $categoryIds = explode(',', $validated['categories']);
    $product->categories()->attach($categoryIds);

    return redirect()->route('mypage')->with('success', '商品が出品されました');
}
}
