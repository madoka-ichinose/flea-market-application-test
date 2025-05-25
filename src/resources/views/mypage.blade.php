@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="profile-section">
        <div class="profile-left">
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="profile-image">
        </div>
        <div class="profile-right">
            <h2>{{ $user->name }}</h2>
            <a href="{{ route('profile.edit') }}" class="profile-edit-link">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-menu">
        <a href="{{ route('mypage', ['tab' => 'selling']) }}"
           class="tab {{ $tab === 'selling' ? 'active' : '' }}">出品した商品</a>

        <a href="{{ route('mypage', ['tab' => 'bought']) }}"
           class="tab {{ $tab === 'bought' ? 'active' : '' }}">購入した商品</a>
    </div>

    @if ($tab === 'selling')
        <div class="product-list">
            @foreach ($sellingProducts as $product)
                <div class="product-item">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                    <p>{{ $product->product_name }}</p>
                </div>
            @endforeach
        </div>
    @elseif ($tab === 'bought')
        <div class="product-list">
            @foreach ($boughtProducts as $product)
                <div class="product-item">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                    <p>{{ $product->product_name }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection