<?php

namespace App\Todo\UseCase;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

final class TaskCreateUseCase
{
  /**
   * タスク作成
   * ・タスク数 = 最大５個
   * ・todo_bodyには不正な値が来ないようにバリデーション
   * 
   * @param string $body 
   */
  public function handle(string $body)
  {
    $tasks = Todo::where('user_id', Auth::id());

    // タスクの数が５個以下ならタスクを作成する
    if ($tasks->count() < 5) {
      $tasks->create([
        'todo_body' => $body,
        'todo_status' => '0',
        'user_id' => Auth::id()
      ]);
    }
  }
}
