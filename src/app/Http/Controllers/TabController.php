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

        $products = collect();  // 初期化
        $favorites = collect();

        if ($tab === 'product') {
            // 「おすすめ」：自分の出品以外の全商品
            $products = Product::when(auth()->check(), function ($query) {
                return $query->where('user_id', '!=', auth()->id());
            })->orderBy('is_sold')->latest()->get();

        } elseif ($tab === 'favorites') {
            // 「マイリスト」：お気に入り商品のうち、自分の出品以外
            if (auth()->check()) {
                $favorites = Favorite::with('product')
                    ->where('user_id', auth()->id())
                    ->whereHas('product', function ($query) {
                        $query->where('user_id', '!=', auth()->id());
                    })
                    ->get()
                    ->pluck('product'); // Productだけ抽出してコレクションに
            }
        }

        return view('index', compact('tab', 'products', 'favorites'));
    }
}
