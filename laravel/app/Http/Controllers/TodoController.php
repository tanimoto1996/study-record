<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTodoRequest;
use App\Models\Todo;
use App\Todo\UseCase\TaskCreateUseCase;

class TodoController extends Controller
{
    /**
     * 一覧画面（TODO）
     * @param App\Models\Todo $todos
     * @return Response
     */
    public function showTodoList(Todo $todos)
    {
        $tasks = $todos->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view("todos.list", [
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成
     * @param App\Http\Requests\CreateTodoRequest $request
     * @param App\Models\Todo $todos
     * @return Response
     */
    public function taskCreate(CreateTodoRequest $request, TaskCreateUseCase $tasks)
    {
        $tasks->handle($request->todo_body);

        return redirect()->route('todo.list');
    }

    /**
     * タスク削除
     * @param App\Models\Todo $todos
     * @param integer $task_id
     * @return Response
     */
    public function taskDelete(Todo $todos, int $task_id)
    {
        $todos->where('id', $task_id)->delete();

        return redirect()->route('todo.list');
    }

    /**
     * 終了タスクを一括削除
     * @param App\Models\Todo $todos
     * @return Response
     */
    public function downTaskDelete(Todo $todos)
    {
        $todos->where('user_id', Auth::id())->where('todo_status', 1)->delete();

        return redirect()->route('todo.list');
    }

    /**
     * タスクをステータス順に並び替え
     * @param App\Models\Todo $todos
     * @return Response
     */
    public function taskSort(Todo $todos)
    {
        $tasks = $todos->where('user_id', Auth::id())->orderBy('todo_status', 'asc')->get();

        return view("todos.list", [
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスクの内容を更新（ajax）
     * @param App\Models\Todo $todos
     * @param Illuminate\Http\Request $request
     * @return Response
     */
    public function taskBodyUpdate(Todo $todos, Request $request)
    {
        $task = $todos->where('id', $request->task_id);

        dd($task);

        $task->update([
            'todo_body' => $request->task_body
        ]);

        return redirect()->route('todo.list');
    }

    /**
     * タスクのステータス変更（ajax）
     * @param App\Models\Todo $todos
     * @param Illuminate\Http\Request $request
     * @return Response
     */
    public function taskStatusUpdate(Todo $todos, Request $request)
    {
        $task = $todos->where('id', $request->task_id);

        $task->update([
            'todo_status' => (int)$request->task_checkd
        ]);

        return redirect()->route('todo.list');
    }
}
