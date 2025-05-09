@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="purchase-wrapper">
    <div class="purchase-left">
        <div class="product-info">
            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
            <div class="product-details">
                <p><strong>{{ $product->product_name }}</strong></p>
                <p>¥{{ number_format($product->price) }}</p>
            </div>
        </div>

        <form id="purchase-form" method="POST" action="{{ route('purchase.pay') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group">
                <label for="payment_method">支払い方法</label><br>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="">選択してください</option>
                    <option value="convenience">コンビニ支払い</option>
                    <option value="card">カード支払い</option>
                </select>
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
        </form>
    </div>

    <div class="purchase-summary">
        <div class="summary-box">
            <p><strong>商品代金</strong>¥{{ number_format($product->price) }}</p>
            <p><strong>支払い方法</strong><span id="payment_summary">未選択</span></p>
        </div>
        <button type="submit" class="btn-danger">購入する</button>
    </div>
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex].text;
        document.getElementById('payment_summary').innerText = selected;
    });
</script>
@endsection
