@extends('layout.app')

@section('title', "カレンダー")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/calendar/index.css') }}">
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="main-wrapper">

  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="row justify-content-center">
      <div class="col-md-8 mt-3">
        <div class="card">
          <div class="card-header">{{ $calendar->getTitle() }}</div>
          <div class="card-body">
            {!! $calendar->render() !!}
            <!-- モーダル -->
            <div id="modal-1" aria-hidden="true">
              <!-- この div がオーバーレイになるとする -->
              <div tabindex="-1" data-micromodal-close>
                <div role="dialog" aria-modal="true" aria-labelledby="..." aria-describedby="...">
                  <!-- 略 -->
                </div>
              </div>
            </div>

            <!-- 開くボタン -->
            <button data-micromodal-trigger="modal-1">open</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection

@section('js')
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
<script src="{{ asset('assets/js/calendars/index.js') }}"></script>
@endsection
