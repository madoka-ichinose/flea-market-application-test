<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Delivery;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function show(Product $product)
    {
    $user = Auth::user();

    return view('purchase', [
        'product' => $product,
        'user' => $user
    ]);
    }

    public function pay(PurchaseRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $method = $request->payment_method;

        if ($method === 'card') {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
        'price_data' => [
            'currency' => 'jpy',
            'unit_amount' => $product->price,
            'product_data' => [
                'name' => $product->product_name,
            ],
        ],
        'quantity' => 1,
    ]],
        'mode' => 'payment',
        'success_url' => route('purchase.complete', $product->id),
        'cancel_url' => route('purchase.show', $product->id),
]);

        return redirect($session->url);
     }

        if ($method === 'convenience') {
        $this->completePurchase($product);
        return redirect()->route('mypage')->with('success', '購入が完了しました');
    }
        return back()->with('error', '支払い方法を選択してください');
    }

    public function complete($product_id)
{
    $product = Product::findOrFail($product_id);

    $this->completePurchase($product);

    return redirect()->route('mypage')->with('success', '購入が完了しました');
}

    private function completePurchase($product)
{
    if (!$product->is_sold) {
        Purchase::create([
            'buyer_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        $product->is_sold = true;
        $product->save();
    }
}

    public function editAddress($product_id)
    {
    $delivery = Delivery::where('product_id', $product_id)->first();
    
    return view('purchase.address', compact('delivery', 'product_id'));
    }

    public function updateAddress(Request $request, $product_id)
    {
    $request->validate([
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'building' => 'nullable|string|max:255',
    ]);

    $delivery = Delivery::updateOrCreate(
        [
        'user_id'    => Auth::id(),
        'product_id' => $product_id,
    ],
    [
        'postal_code' => $request->postal_code,
        'address'     => $request->address,
        'building'    => $request->building,
    ]);

    return redirect()->route('purchase.show', ['product' => $product_id])
                     ->with('success', '住所を更新しました');
    }
}