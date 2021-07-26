@extends('layout.app')

@section('title', "トップ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/top.css') }}">
@endsection

@section('content')

<div class="main-wrapper">

  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="card-content">
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">TODO</h5>
          @foreach ($tasks as $task)
          <p class="card-text">{{ $task->todo_body ?? '' }}</p>
          @endforeach
        </div>
      </div>
      <div class="card card-memo" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">メモ</h5>
          @foreach ($memos as $memo)
          <p class="card-text">{{ $memo->memo_title ?? '' }}</p>
          @endforeach
        </div>
      </div>
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">本日の予定</h5>
          <p class="card-text">{{ $calendar->calendar_body ?? '' }}</p>
        </div>
      </div>
    </div>

    <!-- ここのデザインはグラフでもいいかも？ -->
    <div class="card study-total-time w-75">
      <div class="card-body">
        <h5 class="card-title">学習時間</h5>
        <form action="{{ route('top.time') }}" method="post">
          @csrf
          <input type="time" name="study_time" value="00:00">
          <input type="submit" value="送信">
        </form>
        <p class="card-text">合計{{ $total }}分</p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<!-- <script src="{{ asset('assets/js/header.js') }}"></script> -->
@endsection
