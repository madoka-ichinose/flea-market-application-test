<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit(Product $product)
{
    $user = Auth::user();

    // 既に配送先がある場合は取得
    $delivery = Delivery::firstOrNew([
        'user_id' => $user->id,
        'product_id' => $product->id,
    ], [
        'postal_code' => $user->postal_code,
        'address' => $user->address,
        'building' => $user->building,
    ]);

    return view('purchase.address', compact('user', 'product', 'delivery'));
}

public function update(Request $request, Product $product)
{
    $request->validate([
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'building' => 'nullable|string|max:255',
    ]);

    Delivery::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ],
        [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]
    );

    return redirect()->route('purchase.show', $product->id)->with('success', '配送先住所を更新しました');
}
}
