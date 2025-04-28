@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
  <div class="profile-form__heading">
    <h2>プロフィール設定</h2>
  </div>

  <form action="/mypage/profile" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    @method('POST')

    <!-- プロフィール画像 -->
    <div class="form__group">
      <div class="form__image-wrapper">
        <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.png') }}" alt="プロフィール画像" class="profile-image">
        <label class="form__image-label">
          <input type="file" name="profile_image" style="display: none;">
          <span class="form__image-button">画像を選択する</span>
        </label>
      </div>
    </div>

    <!-- ユーザー名 -->
    <div class="form__group">
      <label for="name" class="form__label">ユーザー名</label>
      <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form__input">
      @error('name')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <!-- 郵便番号 -->
    <div class="form__group">
      <label for="postcode" class="form__label">郵便番号</label>
      <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}" class="form__input">
      @error('postcode')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <!-- 住所 -->
    <div class="form__group">
      <label for="address" class="form__label">住所</label>
      <input type="text" name="address" id="address" value="{{ old('address') }}" class="form__input">
      @error('address')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <!-- 建物名 -->
    <div class="form__group">
      <label for="building" class="form__label">建物名</label>
      <input type="text" name="building" id="building" value="{{ old('building') }}" class="form__input">
      @error('building')
      <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <!-- 更新ボタン -->
    <div class="form__button">
      <button type="submit" class="form__button-submit">更新する</button>
    </div>
  </form>
</div>
@endsection
