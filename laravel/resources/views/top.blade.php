@extends('layout.app')

@section('title', "トップ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
@endsection

@section('content')

<div class="container">
  <button form="logout-button" type="submit">ログアウト</button>
  <form id="logout-button" method="POST" action="{{ route('logout') }}">
    @csrf
  </form>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endsection
