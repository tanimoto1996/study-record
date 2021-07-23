<?php

namespace App\Calendar;

class CalendarWeekBlankDay extends CalendarWeekDay
{

  // 表示しない日付を取得
  function getDay()
  {
    return '0';
  }

  function getClassName()
  {
    return "day-blank";
  }

  function render()
  {
    return '';
  }
}
