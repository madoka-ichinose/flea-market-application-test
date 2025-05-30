<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit(Product $product)
{
    $user = Auth::user();

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

public function update(AddressRequest $request, Product $product)
{
    $validated = $request->validated();

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
