@extends('layout.app')

@section('title', "パスワード再設定")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
@endsection

@section('content')
<div class="container">

  <!-- エラー表示 -->
  @include('components.error_list')

  @if (session('status'))
  <div class="card-text alert alert-success">
    {{ session('status') }}
  </div>
  @endif

  <div class="login-container">
    <div id="output"></div>
    <div class="register-title">
      パスワード再設定
      <div class="login-logo">
        <img src="{{ asset('assets/image/login-logo.png') }}" alt="">
      </div>
    </div>

    <div class="form-box">
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input name="email" type="email" placeholder="メールアドレス" value="{{ old('email') }}">
        <button class="btn btn-info btn-block login" type="submit">メール送信</button>
      </form>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/auth/login.js') }}"></script>
@endsection
