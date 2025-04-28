@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
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

        <div class="icons">
            <span>⭐{{ $product->favorites_count }}</span>
            <span>💬{{ $product->comments_count }}</span>
        </div>

        <button class="purchase-button">購入手続きへ</button>

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
                    <div class="comment-body">{{ $comment->body }}</div>
                </div>
            @endforeach
        </div>

        <div class="section">
            <h2>商品へのコメント</h2>
            <form action="{{ route('comment.store', ['product_id' => $product->id]) }}" method="POST">
                @csrf
                <textarea name="body" placeholder="コメントを入力する" required></textarea>
                <button type="submit" class="comment-button">コメントを投稿する</button>
            </form>
        </div>
    </div>
</div>
@endsection
