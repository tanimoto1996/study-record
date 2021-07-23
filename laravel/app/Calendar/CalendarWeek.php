<?php

namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek
{

  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0)
  {
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  // 週毎にクラス名を作成する
  function getClassName()
  {
    return "week-" . $this->index;
  }

  // 1週間を作成する
  function getDays()
  {
    $days = [];

    // 開始日（１日）~終了日（７日）
    $startDay = $this->carbon->copy()->startOfWeek();
    $lastDay = $this->carbon->copy()->endOfWeek();

    // 現在の日数を取得
    $tmpDay = $startDay->copy();

    // 月曜日から日曜日までループさせる
    while ($tmpDay->lte($lastDay)) {

      // 前後の月の場合は空白を表示
      if ($tmpDay->month != $this->carbon->month) {
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        $days[] = $day;
        // 翌日に移動する
        $tmpDay->addDay(1);
        continue;
      }

      // 今月
      $day = new CalendarWeekDay($tmpDay->copy());
      $days[] = $day;
      $tmpDay->addDay(1);
    }

    return $days;
  }
}
