@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="item-image">
        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
    </div>

    <div class="item-details">
        <h1 class="item-name">{{ $product->product_name }}</h1>
        <p class="brand-name">{{ $product->brand }}</p>
        <p class="price">¥{{ number_format($product->price) }}（税込）</p>

        @auth
        <div class="icons">
            <span id="favorite-count">
                <button id="favorite-button" data-product-id="{{ $product->id }}" 
                style="border: none; background: none; cursor: pointer;">
                <i class="fa{{ $product->isFavoritedBy(auth()->user()) ? 's' : 'r' }} fa-star" 
                id="heart-icon" 
                style="color: {{ $product->isFavoritedBy(auth()->user()) ? 'gold' : 'gray' }}; font-size: 24px;"></i>
                </button><span id="favorite-value">{{ $product->favorites_count }}</span>
            </span>
        <span>💬{{ $product->comments_count }}</span>

        
        </div>
        @endauth
        @auth
            <a href="{{ route('purchase.show', $product->id) }}" class="purchase-button">購入手続きへ</a>
        @else
            <a href="{{ route('login') }}" class="purchase-button">購入にはログインが必要です</a>
        @endauth
        <div class="section">
            <h2>商品説明</h2>
            <p>{{ $product->description }}</p>
        </div>

        <div class="section">
            <h2>商品情報</h2>
            <p>カテゴリー：
                @foreach($product->categories as $category)
                    <span class="category-tag">{{ $category->category_name }}</span>
                @endforeach
            </p>
            <p>商品の状態：{{ $product->condition }}</p>
        </div>

        <div class="section">
            <h2>コメント({{ $product->comments->count() }})</h2>
            @foreach($product->comments as $comment)
                <div class="comment">
                    <div class="comment-user">{{ $comment->user->name }}</div>
                    <div class="comment-body">{{ $comment->content }}</div>
                </div>
            @endforeach
        </div>

        <div class="section">
            <h2>商品へのコメント</h2>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                 @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('comment.store', ['product_id' => $product->id]) }}" method="POST">
                @csrf
                <textarea name="content" placeholder="コメントを入力する" required></textarea>
                <button type="submit" class="comment-button">コメントを投稿する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteBtn = document.getElementById('favorite-button');
        const heartIcon = document.getElementById('heart-icon');
        const favoriteValue = document.getElementById('favorite-value');

        favoriteBtn.addEventListener('click', function () {
            const productId = favoriteBtn.getAttribute('data-product-id');

            fetch(`/favorite/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                favoriteValue.textContent = data.count;
                if (data.status === 'added') {
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                    heartIcon.style.color = 'red';
                } else {
                    heartIcon.classList.remove('fas');
                    heartIcon.classList.add('far');
                    heartIcon.style.color = 'gray';
                }
            });
        });
    });
</script>
@endsection
