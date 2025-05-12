@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
  <div class="profile-form__heading">
    <h2>プロフィール設定</h2>
  </div>

  <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    
    <div class="form__group">
      <div class="form__image-wrapper">
        <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.png') }}" alt="プロフィール画像" class="profile-image" id="preview">
        <label class="form__image-label">
          <input type="file" name="profile_image" style="display: none;" onchange="previewImage(this)">
          <span class="form__image-button">画像を選択する</span>
        </label>
      </div>
    </div>

    <div class="form__group">
      <label for="name" class="form__label">ユーザー名</label>
      <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form__input">
      @error('name')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__group">
      <label for="postal_code" class="form__label">郵便番号</label>
      <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}" class="form__input">
      @error('postal_code')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__group">
      <label for="address" class="form__label">住所</label>
      <input type="text" name="address" id="address" value="{{ old('address', Auth::user()->address) }}" class="form__input">
      @error('address')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__group">
      <label for="building" class="form__label">建物名</label>
      <input type="text" name="building" id="building" value="{{ old('building', Auth::user()->building) }}" class="form__input">
      @error('building')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__button">
      <button type="submit" class="form__button-submit">更新する</button>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('preview').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection