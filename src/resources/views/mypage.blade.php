@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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

    <div class="tabs">
        <button class="tab-button active" data-target="selling">出品した商品</button>
        <button class="tab-button" data-target="bought">購入した商品</button>
    </div>

    <div id="selling" class="tab-content active">
        <div class="product-list">
            @foreach ($sellingProducts as $product)
                <div class="product-item">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                    <p>{{ $product->product_name }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div id="bought" class="tab-content">
        <div class="product-list">
            @foreach ($boughtProducts as $product)
                <div class="product-item">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                    <p>{{ $product->product_name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const buttons = document.querySelectorAll('.tab-button');
    const contents = document.querySelectorAll('.tab-content');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => btn.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(button.dataset.target).classList.add('active');
        });
    });
</script>
@endsection