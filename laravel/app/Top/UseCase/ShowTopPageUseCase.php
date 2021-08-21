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
   * 「合計学習時間」取得
   * ・DBに合計学習時間がないので、計算して出力する。
   * 
   *  「１日の学習時間」取得
   * ・DBに１日の学習時間がないので、計算して出力する。
   * 
   * @return array 
   */
  public function handle($month): array
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
      $isTitle = $memo->memo_title;
      if ($isTitle) $memoTitleArray[] = $this->textLimit($memo->memo_title, 10);
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

    // 「学習時間」
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

    // １日ごとの合計を計算して、２次元配列で取得しておく。
    $studyTimeDay = [];
    $replaceTimeArray = [];
    foreach ($times as $time) {
      // 3時間 -> 「3.00」と表示する
      $replaceTime = substr_replace($time->time, '.', mb_strlen($time->time) - 2, 0);
      // 「8/1」と表示する
      $date = date('n/j',  strtotime($time->created_at));
      // array(「3.00」, 「5.00」）
      $replaceTimeArray =  $studyTimeDay[$date] ?? array();
      $replaceTimeArray[] = (float)$replaceTime;
      // 「8/1」 = array(「3.00」, 「5.00」） となる
      $studyTimeDay[$date] = $replaceTimeArray;
    }

    if ($month) {
      // 1ヶ月分の処理
      $dateMonth = [];
      for ($i = 0; $i <= 30; $i++) {
        $date = date('n/j');
        $date = strtotime("-{$i} day", strtotime($date));
        $dateMonth[$i] = date('n/j', $date);
      }


      // １週間前までの１日ごとの学習時間を配列に格納
      $chartStudyTimeDey = [];
      foreach ($dateMonth as $dw) {
        if (isset($studyTimeDay[$dw])) {

          $chartStudyTimeDey[] = array_sum($studyTimeDay[$dw]);
        } else {
          // 時間がない時に、グラフで0時間と記載するので0を入れる
          $chartStudyTimeDey[] = 0;
        }
      }
    } else {
      // 今日から１週間前の日付を「8/1」の形で取得する
      $dateWeek = [];
      for ($i = 0; $i <= 6; $i++) {
        $date = date('n/j');
        $date = strtotime("-{$i} day", strtotime($date));
        $dateWeek[$i] = date('n/j', $date);
      }

      // １週間前までの１日ごとの学習時間を配列に格納
      $chartStudyTimeDey = [];
      foreach ($dateWeek as $dw) {
        if (isset($studyTimeDay[$dw])) {

          $chartStudyTimeDey[] = array_sum($studyTimeDay[$dw]);
        } else {
          // 時間がない時に、グラフで0時間と記載するので0を入れる
          $chartStudyTimeDey[] = 0;
        }
      }
    }


    // dd($chartStudyTimeDey);


    return [
      'tasks' => $taskBodyArray,
      'memos' => $memoTitleArray,
      'calendar' => $calendarBody,
      'total' => $total,
      'chartStudyTimeDey' => $chartStudyTimeDey
    ];
  }
}
