@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>商品の出品</h2>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>商品画像</label><br>
        <label class="image-upload-box">
        <span class="image-upload-button">画像を選択する</span>
        <input type="file" name="image" id="imageInput" required>
        </label>
        <div id="imagePreview" class="image-preview"></div>

        <h3>商品の詳細</h3>

        <label>カテゴリー</label><br>
        <div id="category-buttons">
        @foreach ($categories as $category)
            <button type="button" class="category-btn" data-id="{{ $category->id }}">
            {{ $category->category_name }}
            </button>
        @endforeach
        </div>
        <input type="hidden" name="categories" id="selected-categories">
        <br><br>

        <label>商品の状態</label><br>
        <select name="condition" required>
            <option value="">選択してください</option>
            @foreach(['良好','目立った傷や汚れなし','やや傷や汚れあり','状態が悪い'] as $condition)
                <option value="{{ $condition }}">{{ $condition }}</option>
            @endforeach
        </select><br><br>

        <h3>商品名と説明</h3>

        <label>商品名</label><br>
        <input type="text" name="product_name" required><br><br>

        <label>ブランド名</label><br>
        <input type="text" name="brand"><br><br>

        <label>商品説明</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>販売価格（¥）</label><br>
        <input type="number" name="price" min="0" required><br><br>

        <button type="submit">出品する</button>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.category-btn');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            this.classList.toggle('selected');  
            let selectedCategories = Array.from(selectedCategoriesInput.value.split(',')).filter(Boolean);
            
            if (this.classList.contains('selected')) {
                selectedCategories.push(categoryId);
            } else {
                selectedCategories = selectedCategories.filter(id => id !== categoryId);
            }

            selectedCategoriesInput.value = selectedCategories.join(',');
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="プレビュー画像">`;
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = '';
        }
    });

    const buttons = document.querySelectorAll('.category-btn');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            this.classList.toggle('selected');  
            let selectedCategories = Array.from(selectedCategoriesInput.value.split(',')).filter(Boolean);
            
            if (this.classList.contains('selected')) {
                selectedCategories.push(categoryId);
            } else {
                selectedCategories = selectedCategories.filter(id => id !== categoryId);
            }

            selectedCategoriesInput.value = selectedCategories.join(',');
        });
    });
});

</script>
@endsection
