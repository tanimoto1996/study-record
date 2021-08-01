<?php

namespace App\Top\UseCase;

use Illuminate\Support\Facades\Auth;
use App\lib\helperFunctions;
use App\Models\Memo;
use App\Models\Todo;
use App\Models\Calendar;
use App\Models\StudyTime;

final class ShowTopPageUseCase
{

  use helperFunctions;
  /**
   * 「TODO」一覧取得
   * ・上位５件のみ表示、表示制限２０文字あり。
   * 
   * 「メモ」一覧取得
   * ・上位５件のみ表示、表示制限１０文字あり。
   * 
   * 「カレンダー」本日の予定のみ取得
   * ・ユニックスタイムにて、時間を照らし合わせる。
   * ・表示制限１５０文字あり。
   * 
   * 「学習時間」取得
   * ・DBに合計学習時間がないので、計算して出力する。
   * 
   * @return array 
   */
  public function handle(): array
  {
    // 「TODO」 上位５件表示 ここでtaskのコメント数制限する。
    $tasks = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();
    $taskBodyArray = array();
    foreach ($tasks as $task) {
      // 表示文字数を制限するために再度配列に格納し直す。
      $taskBodyArray[] = $this->textLimit($task->todo_body, 20);
    }

    // 「メモ」 上位５件表示 ここでタイトル数制限する。
    $memos = Memo::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->take(5)->get();
    $memoTitleArray = array();
    foreach ($memos as $memo) {
      // 表示文字数を制限するために再度配列に格納し直す。
      $memoTitleArray[] = $this->textLimit($memo->memo_title, 10);
    }

    // 「カレンダー」文字数制限する。
    // UNIX TIMESTAMPを取得
    $timeStamp = time();
    // 本日の年月日を取得  例）2021年８月１日 ⇨ 202181
    $date = date("Ynj", $timeStamp);
    $calendar = Calendar::where('user_id', Auth::id())->where('calendar_field', $date)->first();
    // 表示文字数を制限するために再度変数に格納し直す
    $calendarBody = "";
    if ($calendar) $calendarBody = $this->textLimit($calendar->calendar_body, 150);

    // 学習時間
    $times = StudyTime::where('user_id', Auth::id())->get();
    $total = 0;
    foreach ($times as $time) {
      // 全ての時間を合計して代入
      $total += $time->time;
    }

    if ($total) {
      // 合計時間を整える
      $total = substr_replace($total, '時間', mb_strlen($total) - 2, 0);
    }

    return [
      'tasks' => $taskBodyArray,
      'memos' => $memoTitleArray,
      'calendar' => $calendarBody,
      'total' => $total
    ];
  }
}
