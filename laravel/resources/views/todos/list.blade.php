@extends('layout.app')

@section('title', "TODO")

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/todos/list.css') }}">
@endsection

@section('content')
<div class="main-wrapper">
  <!-- サイドバー -->
  @include('components.sidebar')

  <div class="main-container">
    <div class="card col-md-10 mt-5 pr-0 pl-0 todo-list-container">
      <div class="card-header">
        Todo List
      </div>
      <div class="card-body">
        <!-- タスク検索 フォーム -->
        <form class="form-inline" action="{{ route('todo.create') }}" method="post">
          @csrf
          <input type="text" class="form-control" name="todo_body" placeholder="新しいタスクを追加する" value="{{ old('todoBody') }}">
          <button type="submit" class="btn btn-primary pb-2 pt-2 pr-4 pl-4" id="taskAdd">追加</button>
        </form>

        @foreach ($tasks as $task)
        <div {!! ($task->todo_status ? 'class="item-row active"' : '') !!}>
          @empty( $task->todo_status )
          <input type="checkbox" class="taskStatus" name="todo_status" data-id="{{ $task->id }}">
          @else
          <input type="checkbox" class="taskStatus" name="todo_status" data-id="{{ $task->id }}" checked>
          @endempty

          <form class="d-inline task-update" method="post">
            @csrf
            <!-- タスク編集 フォーム -->
            @method('patch')
            <input type="text" class="body" formaction="{{ route('todo.update', ['task_id' => $task->id]) }}" name="todo_body" class="d-inline" value="{{ $task->todo_body }}">

            <!-- タスク削除 フォーム -->
            @method('delete')
            <input type="submit" class="d-inline" formaction="{{ route('todo.delete', ['task_id' => $task->id]) }}" value="削除">
          </form>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/todos/list.js')}}"></script>
@endsection
