@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="container">
    @if (session('status'))
        <div style="color: red;">{{ session('status') }}</div>
    @endif

    <div class="tab-menu">
        <a href="{{ route('tab.show', ['tab' => 'product']) }}" class="tab {{ $tab === 'product' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('tab.show', ['tab' => 'favorites']) }}" class="tab {{ $tab === 'favorites' ? 'active' : '' }}">マイリスト</a>
    </div>

    @if ($tab === 'favorites')
    <div id="favorites-list">
        <div class="product-grid">
        @foreach($favorites as $product)
            <div class="product-card {{ $product->is_sold ? 'sold' : '' }}">
                @if (!$product->is_sold)
                    <a href="{{ url('/item/' . $product->id) }}">
                @endif

                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    @if ($product->is_sold)
                        <span class="sold-tag">Sold</span>
                    @endif
                </div>
                <div class="product-name">{{ $product->product_name }}</div>

                @if (!$product->is_sold)
                    </a>
                @endif
            </div>
        @endforeach
        </div>
    </div>
@else
    <div id="product-list">
        <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                @if (!$product->is_sold)
                    <a href="{{ url('/item/' . $product->id) }}">
                @endif

                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    @if ($product->is_sold)
                        <span class="sold-tag">Sold</span>
                    @endif
                </div>
                <div class="product-name">{{ $product->product_name }}</div>

                @if (!$product->is_sold)
                    </a>
                @endif
            </div>
        @endforeach
        </div>
    </div>
@endif
@endsection
