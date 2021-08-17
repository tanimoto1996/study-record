<?php

namespace App\Calendar;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Calendar;

class CalendarWeekView
{

  private $carbon;

  function __construct($date)
  {
    // 受け取った日付を元にオブジェトを生成する。
    $this->carbon = new Carbon($date);
  }

  // タイトル用に現在の年月を取得
  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  /**
   * 次の週
   */
  public function getNextWeek()
  {
    return $this->carbon->copy()->addDays(7)->format('Y-m-d');
  }

  /**
   * 前の週
   */
  public function getPreviousWeek()
  {
    return $this->carbon->copy()->subDays(7)->format('Y-m-d');
  }


  /**
   * カレンダー出力
   */
  function render()
  {

    $calendar = Calendar::where('user_id', Auth::id())->get();

    // カレンダーの情報（filed + body）を連想配列で格納
    $calendar_date = [];
    foreach ($calendar as $date) {
      $text = $date->calendar_body;
      $limit = 15;

      if (mb_strlen($text) > $limit) {
        // 文字の末尾に「・・・」をつける
        $text = mb_substr($text, 0, $limit) . "･･･";
      }

      $calendar_date[$date->calendar_field] = $text;
    }

    // フィールドカラムを配列に格納
    $calendar_field_array = array_column($calendar->toArray(), 'calendar_field');
    $youbi = ['月', '火', '水', '木', '金', '土', '日'];

    $html = [];
    $html[] = '<div class="calendar">';
    $weeks = $this->getWeeks();

    foreach ($weeks as $week) {
      $html[] = '<div class="' . $week->getClassName() . '">';
      $days = $week->getDays();
      $count = 0;
      foreach ($days as $day) {
        $date = $this->carbon->format('Yn') . $day->getDay();
        $html[] = '<div class="' . $day->getClassName() . '">';
        $html[] = '<div class="youbi-day-wrap">' . $day->render() . $youbi[$count] . '</div>';
        $html[] = '<div>';
        $html[] = '<input type="hidden" value="' . $date . '">';
        if (
          array_search($date, $calendar_field_array) ||
          array_search($date, $calendar_field_array) === 0
        ) {
          // カレンダー一覧に内容を出す
          $html[] = '<div>' . $calendar_date[$date]  . '</div>';
        }
        $html[] = '</div>';
        $html[] = '</div>';
        $count += 1;
      }
      $html[] = '</div>';
    }

    $html[] = '</div>';
    return implode("", $html);
  }

  /**
   * １ヶ月のカレンダーを取得する
   */
  protected function getWeeks()
  {
    $weeks = [];

    // 初日
    $firstDay = $this->carbon->copy()->startOfWeek();

    // 1週間
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;

    return $weeks;
  }
}
