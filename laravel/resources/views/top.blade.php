@extends('layout.app')

@section('title', "トップ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
@endsection

@section('content')

<div class="main-wrapper">
  <div class="side-bar">
    <ul>
      <li><a href="#">TOP</a></li>
      <li><a href="#">TODO<a></li>
      <li><a href="#">MEMO<a></li>
      <li><a href="#">CLENDAR<a></li>
    </ul>
  </div>
  <div class="main-container">
    <div class="card-content">
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">TODO</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
      <div class="card card-memo" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">MEMO</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">CLENDAR</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>

    <!-- ここのデザインはグラフでもいいかも？ -->
    <div class="card study-total-time w-75">
      <div class="card-body">
        <h5 class="card-title">学習時間</h5>
        start time ~ end time
        <p class="card-text">合計20時間</p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<!-- <script src="{{ asset('assets/js/header.js') }}"></script> -->
@endsection
