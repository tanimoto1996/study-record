<?php

namespace App\Calendar;

use Carbon\Carbon;

class CalendarView
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

  // カレンダーを出力
  function render()
  {
    $html = [];
    $html[] = '<div class="calendar">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';

    $html[] = '<tbody>';

    $weeks = $this->getWeeks();

    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';
      $days = $week->getDays();
      foreach ($days as $day) {
        $html[] = '<td class="' . $day->getClassName() . '">';
        $html[] = $day->render();
        $html[] = '<input type="hidden" value="' . $this->carbon->format('Yn') . $day->getDay() . '">';
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }

    $html[] = '</tbody>';

    $html[] = '</table>';
    $html[] = '</div>';
    return implode("", $html);
  }

  // １ヶ月のカレンダーを取得する
  protected function getWeeks()
  {
    $weeks = [];

    // 初日
    $firstDay = $this->carbon->copy()->firstOfMonth();

    // 最終日
    $lastDay = $this->carbon->copy()->lastOfMonth();

    // 1週間
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;

    // ２週間目の月曜日を設定
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

    // 月末までループさせる lte関数＝以下
    while ($tmpDay->lte($lastDay)) {
      // 週カレンダーViewを作成
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;

      $tmpDay->addDay(7);
    }

    return $weeks;
  }
}
