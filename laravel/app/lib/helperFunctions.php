<?php

namespace App\lib;

trait helperFunctions
{
  /**
   * 文字数制限
   * @param string $text 制限したい文字列
   * @param intger $limit 制限したい文字数 
   * @return string
   */
  public static function textLimit($text, $limit = 15): string
  {
    if (mb_strlen($text) > $limit) {
      // 文字の末尾に「・・・」をつける
      $text = mb_substr($text, 0, $limit) . "…";
    }

    return $text;
  }
}
