<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();
        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $status = 'added';
        }

        $count = $product->favorites()->count();

        return response()->json(['status' => $status, 'count' => $count]);
    }
}