<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $productIds = $request->input('product_ids');
        $products = Product::find($productIds);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
        ]);

        foreach ($products as $product) {
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);

            $product->is_sold = true;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', '購入が完了しました');
    }
}
