<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $sellingProducts = Product::where('user_id', $user->id)->get();

        $boughtProducts = Purchase::where('buyer_id', $user->id)
            ->with('product')
            ->get()
            ->pluck('product')
            ->filter();

        return view('mypage', [
            'user' => $user,
            'sellingProducts' => $sellingProducts,
            'boughtProducts' => $boughtProducts,
        ]);
    }
}
