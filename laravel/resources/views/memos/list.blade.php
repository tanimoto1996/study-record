@extends('layout.app')

@section('title', "メモ")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/memos/list.css') }}">
@endsection

@section('content')
<div class="main-wrapper">
  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="h-100 bg-white">
      <div class="row h-100 m-0 p-0">
        <div class="left-contents col-3 h-100 m-0 p-0 border-left border-right border-gray">
          <div class="d-flex justify-content-between align-items-center">
            <div class="left-memo-title h5 pl-3 pt-3">
              メモリスト
            </div>
            <div class="left-add-icon">
              <i class="fas fa-plus"></i>
            </div>
          </div>
          <div class="left-memo-list list-group-flush p-0">
            <a href="" class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">タイトル</h5>
                <small>2020/08/01 12:00</small>
              </div>
              <p class="mb-1">
                詳細内容XXXXXXXXXXX
              </p>
            </a>
          </div>
        </div>
        <div class="col-9 h-100">
          <form class="w-100 h-100" method="post">
            <input type="hidden" name="edit_id" value="" />

            <div class="d-flex input-area">
              <input type="text" id="memo-title" class="border-0 h4 mt-3" name="edit_title" placeholder="タイトルを入力する..." value="" />
              <textarea id="memo-body" class="border-0" name="edit_body" placeholder="内容を入力する..."></textarea>
            </div>

            <div class="text-right" id="memo-menu">
              <button type="button" class="btn btn-danger" formaction="">削除</button>
              <button type="button" class="btn btn-success" formaction="">保存</button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/memos/list.js')}}"></script>
@endsection
