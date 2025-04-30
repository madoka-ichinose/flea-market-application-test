@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>購入手続き</h2>
    
    <div class="product-info">
        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="150">
        <p><strong>{{ $product->name }}</strong></p>
        <p>¥{{ number_format($product->price) }}</p>
    </div>

    <form id="purchase-form" method="POST" action="{{ route('purchase.pay') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="price" value="{{ $product->price }}">

        <div class="form-group">
            <label for="payment_method">支払い方法</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>

        <div class="summary">
            <p>商品代金：¥<span id="total_price">{{ number_format($product->price) }}</span></p>
            <p>支払い方法：<span id="payment_summary">未選択</span></p>
        </div>

        @php
        $delivery = \App\Models\Delivery::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
        @endphp

        <div class="shipping">
        <h4>配送先</h4>
    
        @if ($delivery)
        <p>〒 {{ $delivery->postal_code }}</p>
        <p>{{ $delivery->address }} {{ $delivery->building }}</p>
         @else
        <p>〒 {{ $user->postal_code }}</p>
        <p>{{ $user->address }} {{ $user->building }}</p>
        @endif

        <a href="{{ route('purchase.address.edit', $product->id) }}">変更する</a>
        </div>

        <button type="submit" class="btn btn-danger">購入する</button>
    </form>
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex].text;
        document.getElementById('payment_summary').innerText = selected;
    });
</script>
@endsection
