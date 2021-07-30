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
        <div class="card-body bg-info text-white">
          <h5 class="card-title"><a href="{{ route('todo.list') }}" class="text-white">TODO</a></h5>
          @if($tasks)
          <?php $count = 1; ?>
          @foreach ($tasks as $task)
          <p class="card-text text-white" style="border-bottom: 1px solid;"><?php echo $count ?> . {{ $task ?? '' }}</p>
          <?php $count += 1 ?>
          @endforeach
          @else
          <p class="card-text text-white">タスクがありません</p>
          @endif
        </div>
      </div>
      <div class="card card-memo" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title"><a href="{{ route('memo.list') }}" class="text-muted">メモ</a></h5>
          @if($memos)
          <?php $count = 1; ?>
          @foreach ($memos as $memo)
          <p class="card-text" style="border-bottom: 1px solid;"><?php echo $count ?> . {{ $memo ?? '' }}</p>
          <?php $count += 1 ?>
          @endforeach
          @else
          <p class="card-text">メモがありません</p>
          @endif
        </div>
      </div>
      <div class="card" style="width: 18rem; background: #7d7d7d;">
        <div class="card-body text-white">
          <h5 class="card-title"><a href="{{ route('calendar.index') }}" class="text-white">本日の予定</a></h5>
          @if($calendar)
          <p class="card-text text-white">{{ $calendar ?? '' }}</p>
          @else
          <p class="card-text text-white">予定がありません</p>
          @endif
        </div>
      </div>
    </div>

    <!-- ここのデザインはグラフでもいいかも？ -->
    <div class="card study-total-time w-75">
      <div class="card-body">
        <h5 class="card-title text-muted">学習時間</h5>
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
