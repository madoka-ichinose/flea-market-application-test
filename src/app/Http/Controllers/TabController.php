<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;

class TabController extends Controller
{
    public function show(Request $request)
    {
        $tab = $request->input('tab', 'product');
        $keyword = $request->input('keyword');
    
        $products = collect();
        $favorites = collect();
    
        if ($tab === 'product') {
            $productsQuery = Product::query();
    
            if (auth()->check()) {
                $productsQuery->where('user_id', '!=', auth()->id());
            }
    
            if (!empty($keyword)) {
                $productsQuery->where('product_name', 'like', '%' . $keyword . '%');
            }
    
            $products = $productsQuery->orderBy('is_sold')->latest()->get();
        } elseif ($tab === 'favorites') {
            if (auth()->check()) {
                $favoritesQuery = Favorite::with('product')
                    ->where('user_id', auth()->id())
                    ->whereHas('product', function ($query) use ($keyword) {
                        $query->where('user_id', '!=', auth()->id());
    
                        if (!empty($keyword)) {
                            $query->where('product_name', 'like', '%' . $keyword . '%');
                        }
                    });
    
                $favorites = $favoritesQuery->get()->pluck('product');
            }
        }
    
        return view('index', compact('tab', 'products', 'favorites', 'keyword'));
    }
    
}
