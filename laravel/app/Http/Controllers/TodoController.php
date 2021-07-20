<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // トップ画面(Todo)
    public function showTodoList()
    {
        $tasks = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view("todos.list", [
            'tasks' => $tasks,
        ]);
    }

    // タスク作成
    public function taskCreate(CreateTodoRequest $request)
    {
        // TODO 登録の処理を usecaseファイルに記述
        $tasks = Todo::where('user_id', Auth::id());

        // タスクの数が５個以下ならタスクを作成する
        if ($tasks->count() < 5) {
            $tasks->create([
                'todo_body' => $request->todo_body,
                'todo_status' => '0',
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('todo.list');
    }

    // タスク編集
    public function taskUpdate(CreateTodoRequest $request, int $task_id)
    {
        $task = Todo::where('id', $task_id);

        $task->update([
            'todo_body' => $request->todo_body,
        ]);

        return redirect()->route('todo.list');
    }

    // タスク削除
    public function taskDelete(int $task_id)
    {
        Todo::where('id', $task_id)->delete();

        return redirect()->route('todo.list');
    }

    // タスクのステータス変更
    public function taskStatusUpdate(Request $request)
    {
        $task = Todo::where('id', $request->task_id);

        $task->update([
            'todo_status' => (int)$request->task_checkd
        ]);

        return redirect()->route('todo.list');
    }
}
