@extends('layout.app')

@section('title', "ログイン")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
@endsection

@section('content')
<div class="container">

  <!-- エラー表示 -->
  @include('components.error_list')

  <div class="login-container">
    <div id="output"></div>
    <div class="register-title">
      ログイン
      <div class="login-logo">
        <img src="{{ asset('assets/image/login-logo.png') }}" alt="">
      </div>
    </div>

    <div class="form-box">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input name="email" type="email" placeholder="メールアドレス" value="{{ old('email') }}">
        <input name="password" type="password" placeholder="パスワード" required>
        <input type="hidden" type="remember" id="remember" value="on">
        <button class="btn btn-info btn-block login" type="submit">ログイン</button>
      </form>
    </div>
    <div class="login-here">
      <a href="{{ route('register') }}">アカウント作成</a>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/auth/login.js') }}"></script>
@endsection
