@extends('layout.app')

@section('title', "新規登録")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
@endsection

@section('content')

<!-- ここから作成 note参考に画面の作成をしていく -->
<div class="container">
  <div class="login-container">
    <div id="output"></div>
    <div class="register-title">
      ユーザー登録
      <div class="login-logo">
        <img src="{{ asset('assets/image/login-logo.png') }}" alt="">
      </div>
    </div>
    <div class="form-box">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <input name="name" type="text" placeholder="名前" value="{{ old('name') }}">
        <input name="email" type="email" placeholder="メールアドレス" value="{{ old('email') }}">
        <input name="password" type="password" placeholder="パスワード" required>
        <button class="btn btn-info btn-block login" type="submit">ユーザー登録</button>
      </form>
    </div>
    <div class="login-here">
      <a href="{{ route('login') }}">ログインはこちら</a>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endsection
