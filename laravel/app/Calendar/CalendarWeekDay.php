<?php

namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeekDay
{
  protected $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  // 日付を取得
  function getDay()
  {
    return $this->carbon->format("j");
  }

  // 日毎にクラス名を作成する
  function getClassName()
  {
    return "day-field day-" . strtolower($this->carbon->format("D"));
  }

  // 日付のHTMLを返す
  function render()
  {
    return '<p class="day">' . $this->carbon->format("j") . '</p>';
  }
}
