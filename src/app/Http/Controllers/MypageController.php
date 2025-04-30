<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $sellingProducts = Product::where('seller_id', $user->id)->get();

        $boughtProducts = Product::where('buyer_id', $user->id)->get();

        return view('mypage', compact('user', 'sellingProducts', 'boughtProducts'));
    }
}
