@extends('layout.app')

@section('title', "トップ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/top.css') }}">
@endsection

@section('content')

<div class="main-wrapper">

  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="card-content">
      <div class="card" style="width: 18rem;">
        <!-- TODO -->
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

      <!-- メモ -->
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

      <!-- カレンダー -->
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

    <!-- 学習時間 -->
    <div class="card study-total-time w-75">
      <div class="card-body">
        @if ($error_time)

        <div class="alert alert-danger" role="alert">
          <span>{{ $error_time }}</span>
        </div>

        @endif
        <div class="study-time-wrap">
          <h5 class="card-title text-muted">学習時間<span class="card-text">（合計{{ $total }}分）</span></h5>
          <form action="{{ route('top.time') }}" method="post">
            @csrf
            <div class="mt-3">
              <input type="time" class="" name="study_time" value="00:00" required>
              <input type="submit" class="btn btn-primary btn btn-primary pt-2 pb-2 pr-4 pl-4" value="送信">
            </div>
          </form>
        </div>

        <div class="canvas-contrainer">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>

    <!-- グラフで使う１日の時間の情報を持っておく -->
    @for($i = 0; $i <= 6; $i++) <span class="d-none" id="studyTime{{ $i }}">{{ $chartStudyTimeDey[$i] }}</span>
      @endfor



  </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script src="{{ asset('assets/js/tops/top.js') }}"></script>
@endsection
