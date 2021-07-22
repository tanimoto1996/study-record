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

        <!-- メモ一覧（左） -->
        <div class="left-contents col-3 h-100 m-0 p-0 border-left border-right border-gray">
          <div class="d-flex justify-content-between align-items-center">
            <div class="left-memo-title h5 pl-3 pt-3">
              メモリスト
            </div>
            <div class="left-add-icon">
              <a href="{{ route('memo.create') }}"><i class="fas fa-plus"></i></a>
            </div>
          </div>
          @foreach ($memos as $memo)
          <div class="left-memo-list list-group-flush p-0">
            <a href="{{ route('memo.select', ['id' => $memo->id]) }}" class="list-group-item list-group-item-action @if ($select_memo) {{ $select_memo->id == $memo->id ? 'active' : '' }} @endif">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $memo->memo_title }}</h5>
                <small>{{ $memo->updated_at }}</small>
              </div>
              <p class="mb-1">
                @if(mb_strlen($memo->content) <= 100) {{ $memo->memo_body }} @else {{ mb_substr($memo->memo_body , 0, 100) . "..." }} @endif </p>
            </a>
          </div>
          @endforeach
        </div>

        <!-- メモ入力（右） -->
        <div class="col-9 h-100">
          @if ($select_memo)
          <form class="w-100 h-100" method="post">
            @csrf
            <input type="hidden" name="edit_id" value="{{ $select_memo->id }}">
            <div class="d-flex input-area">
              <input type="text" id="memo-title" class="border-0 h4 mt-3" name="edit_title" placeholder="タイトルを入力する..." value="{{ $select_memo->memo_title }}">
              <textarea id="memo-body" class="border-0" name="edit_body" placeholder="内容を入力する...">{{ $select_memo->memo_body }}</textarea>
            </div>
            <div class="text-right" id="memo-menu">
              <button type="submit" class="btn btn-danger" formaction="{{ route('memo.delete') }}">削除</button>
              <button type="submit" class="btn btn-success" formaction="{{ route('memo.update') }}">保存</button>
            </div>
          </form>
          @else
          <div>
            メモを新規作成するか選択してください
          </div>
          @endif
        </div>

      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/memos/list.js')}}"></script>
@endsection
