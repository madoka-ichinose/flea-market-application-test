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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>商品画像</label><br>
        <label class="image-upload-box">
        <span class="image-upload-button">画像を選択する</span>
        <input type="file" name="image" id="imageInput" required>
        </label>
        <div id="imagePreview" class="image-preview"></div>
        @error('image')
            <div style="color:red;">{{ $message }}</div>
        @enderror

        <h3>商品の詳細</h3>

        <label>カテゴリー</label><br>
        <div id="category-buttons">
        @foreach ($categories as $category)
            <button type="button" class="category-btn" data-id="{{ $category->id }}">
            {{ $category->category_name }}
            </button>
        @endforeach
        </div>
        <input type="hidden" name="categories" id="selected-categories" value="{{ old('categories') }}">
        @error('categories')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <label>商品の状態</label><br>
        <select name="condition" required>
            <option value="">選択してください</option>
            @foreach(['良好','目立った傷や汚れなし','やや傷や汚れあり','状態が悪い'] as $condition)
                <option value="{{ $condition }}" {{ old('condition') == $condition ? 'selected' : '' }}>{{ $condition }}</option>
            @endforeach
        </select>
        @error('condition')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <h3>商品名と説明</h3>

        <label>商品名</label><br>
        <input type="text" name="product_name" value="{{ old('product_name') }}">
        @error('product_name')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <label>ブランド名</label><br>
        <input type="text" name="brand" value="{{ old('brand') }}">
        @error('brand')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <label>商品説明</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <label>販売価格（¥）</label><br>
        <input type="number" name="price" min="0" value="{{ old('price') }}">
        @error('price')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <button type="submit">出品する</button>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.category-btn');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    let selectedCategories = Array.from(selectedCategoriesInput.value.split(',')).filter(Boolean);
    buttons.forEach(button => {
        if (selectedCategories.includes(String(button.getAttribute('data-id')))) {
    button.classList.add('selected');
}

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
});
</script>
@endsection
