@extends('layout.app')

@section('title', "カレンダー")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/calendar/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.31/example1/colorbox.min.css" integrity="sha512-qDmL8zJf49wqgbTQEr0nsThYpyQkjc+ulm2zAjRXd/MCoUBuvd19fP2ugx7dnxtvMOzSJ1weNdSE+jbSnA4eWw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')

<div class="main-wrapper">

  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="row justify-content-center">
      <div class="col-md-8 mt-3">
        <div class="card">
          <div class="card-header text-center">
            <a class="btn btn-outline-secondary float-left" href="{{ url('calendar/?date=' . $calendar->getPreviousMonth()) }}">前の月</a>
            <span>{{ $calendar->getTitle() }}</span>
            <a class="btn btn-outline-secondary float-right" href="{{ url('calendar/?date=' . $calendar->getNextMonth()) }}">次の月</a>
          </div>
          <div class="card-body">
            {!! $calendar->render() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modalBox"></div>

</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js" integrity="sha512-DAVSi/Ovew9ZRpBgHs6hJ+EMdj1fVKE+csL7mdf9v7tMbzM1i4c/jAvHE8AhcKYazlFl7M8guWuO3lDNzIA48A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/js/calendars/index.js') }}"></script>
@endsection
