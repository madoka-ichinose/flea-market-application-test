@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@endsection

@section('content')
<div class="container">
    <div>
        <span class="tab {{ $tab == 'product' ? 'active' : '' }}" onclick="switchTab('product')">おすすめ</span>
        <span class="tab {{ $tab == 'favorites' ? 'active' : '' }}" onclick="switchTab('favorites')">マイリスト</span>
    </div>

    <div id="product-list" style="{{ $tab == 'product' ? '' : 'display:none;' }}">
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                 <a href="{{ url('/item/' . $product->id) }}">
                  <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    @if ($product->is_sold)
                    <span class="sold-tag">Sold</span>
                    @endif
                  </div>
                    <div>{{ $product->product_name }}</div>
                 </a>
                </div>
            @endforeach
        </div>
    </div>

    <div id="favorites-list" style="{{ $tab == 'favorites' ? '' : 'display:none;' }}">
        <div class="product-grid">
            @foreach($favorites as $favorite)
                <div class="product-card">
                  <a href="{{ url('/item/' . $favorite->product->id) }}">
                    <img src="{{ asset('storage/' . $favorite->product->image) }}" alt="商品画像">
                    <div>{{ $favorite->product->product_name }}</div>
                  </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function switchTab(tab) {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.location.href = url.toString();
    }
</script>
@endsection
