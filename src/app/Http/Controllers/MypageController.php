<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $tab = $request->query('tab', 'selling'); 

    $sellingProducts = Product::where('user_id', $user->id)->get();

    $boughtProducts = Purchase::with('product')
        ->where('buyer_id', $user->id)
        ->get()
        ->pluck('product');

    return view('mypage', compact('user', 'tab', 'sellingProducts', 'boughtProducts'));
}
}
