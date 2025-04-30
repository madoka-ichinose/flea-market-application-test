<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;

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

    public function pay(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $method = $request->payment_method;

        if ($method === 'card') {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('home') . '?success=true',
            'cancel_url' => route('home') . '?canceled=true',
        ]);

        return redirect($session->url);
     }

        if ($method === 'convenience') {
        return redirect()->route('convenience.show');
        }

        return back()->with('error', '支払い方法を選択してください');
    }

    public function editAddress($product_id)
    {
    $delivery = Delivery::where('product_id', $product_id)->first();
    
    return view('purchase.address', [
        'product_id' => $product_id,
        'delivery' => $delivery,
    ]);
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