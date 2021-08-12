@extends('layout.app')

@section('title', "TODO")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/todos/list.css') }}">
@endsection

@section('content')
<div class="main-wrapper">
  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="card col-md-5 mt-5 pr-0 pl-0 todo-list-container">
      <div class="card-header">
        Todo List
      </div>
      <div class="card-body">
        <!-- タスク検索 フォーム -->
        <form class="form-inline" action="{{ route('todo.create') }}" method="post">
          @csrf
          <input type="text" class="form-control rounded-0" name="todo_body" placeholder="新しいタスクを追加する" value="{{ old('todoBody') }}">
          <button type="submit" class="btn btn-primary ml-0 pr-4 pl-4 rounded-0" id="taskAdd">追加</button>
        </form>

        <!-- タスク一覧 -->
        <div class="task">
          <ul class="task-list">
            @foreach ($tasks as $task)
            <li class="task-item @if ($task->todo_status) {{ 'item-row active' }} @endif">

              <form class="task-post-form" method="post">
                @csrf
                <div class="d-flex">
                  <div class="form-check form-check-inline">
                    <input type="checkbox" class="taskStatus" name="todo_status" data-id="{{ $task->id }}" @if ($task->todo_status) checked @endif>
                    <label class="form-check-label" for="inlineCheckbox1"></label>
                  </div>
                  <!-- タスク編集 フォーム -->
                  <div class="task-update">
                    @method('patch')
                    <input type="text" data-id="{{ $task->id }}" name="todo_body" class="body d-inline @if ($task->todo_status) {{ 'showLineCancel' }} @endif" value="{{ $task->todo_body }}" @if ($task->todo_status) disabled @endif>
                  </div>
                </div>

                <!-- タスク削除 フォーム -->
                <div class="task-delete">
                  @method('delete')
                  <button type="submit" formaction="{{ route('todo.delete', ['task_id' => $task->id]) }}"><i class="fas fa-trash-alt"></i></button>
                </div>
              </form>

            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/todos/list.js')}}"></script>
@endsection
