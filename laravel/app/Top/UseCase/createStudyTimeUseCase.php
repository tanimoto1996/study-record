<?php

namespace App\Top\UseCase;

use Illuminate\Support\Facades\Auth;

final class createStudyTimeUseCase
{

  /**
   * 
   * ・「１日の合計学習時間」が24時間を超えていないかを判定する
   *   超えている場合は、処理を流しエラーを表示する。
   *   エラー内容はセッションで管理する。
   * 
   * ・エラーがなければ、時間をデータベースに保存する
   * 
   * @return null
   */
  public function handle($times, $request)
  {
    // 本日の日付を取得
    $today = date("Y-m-d");

    // 本日の日付と一致している時間を取得
    $todayTime = $times->where('user_id', Auth::id())->where('created_at', 'like', '%' . $today . '%')->get();

    // 1日24時間以上を超えた値を入れれないように制御する
    $totalTime = array();
    foreach ($todayTime as $time) {
      $totalTime[] = $time->time;
    }

    // セッションがあったら削除する
    if (session('error_time')) {
      session()->remove('error_time');
    }

    // timeカラムがint型のためコロンを排除する
    $responsTime = str_replace(":", "", $request->study_time);
    $totalTime[] = (int)$responsTime;

    if (array_sum($totalTime) > 2400) {
      // 24時間を超えていた場合、エラー内容をセッションに保存する
      session()->put('error_time', '１日の勉強時間の合計で「24時間」を超える時間は入力できません。');
    } else {
      // 24時間超えていなければデーターベースに値を挿入する
      // timeカラムがint型のためコロンを排除する
      $time = str_replace(":", "", $request->study_time);
      $times->create([
        'time' => (int)$time,
        'user_id' => Auth::id()
      ]);
    }
  }
}
