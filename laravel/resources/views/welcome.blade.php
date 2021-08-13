@extends('layout.app')

@section('title', "紹介ページ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
@endsection

@section('content')

<div class="welcome-wrapper welcome-bg">
    <div class="content">
        <p class="text-jp"><span>今</span>、勉強を始めませんか？</p>
        <p class="text-en">Would you like to start studying now?</p>
    </div>
</div>


@endsection

@section('js')
@endsection
