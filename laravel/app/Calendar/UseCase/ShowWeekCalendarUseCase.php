<?php

namespace App\Calendar\UseCase;

final class ShowWeekCalendarUseCase
{

  /**
   * 選択中の年月日(YYYY-MM-dd)を取得し、カレンダー処理で活用するため、
   * ユニックスタイムを返す。
   * 
   * @param string $date
   * @return int $date
   */
  public function handle(string $date): int
  {
    //dateがYYYY-MM-ddの形式かどうか判定する
    if ($date && preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $date)) {
      $date = strtotime($date . "-02");
    } else {
      $date = null;
    }

    //取得出来ない時は現在(=今月)を指定する
    if (!$date) $date = time();

    return $date;
  }
}
