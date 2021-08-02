<?php

namespace App\Memo\UseCase;

use App\lib\helperFunctions;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

final class ShowMemoListUseCase
{

  use helperFunctions;

  /**
   * メモ一覧
   * ・タイトル： 15文字制限
   * ・内容： 50文字制限
   * 
   * 文字制限したタイトルと内容を取り出しやすいように、
   * ２次元配列に格納する。
   * 
   * 未入力時は配列に格納しない。
   * 
   * @return array  
   */
  public function handle()
  {
    $memos = Memo::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

    $memoTextLimitArray = array();
    foreach ($memos as $memo) {

      $isTitle = $memo->memo_title ? true : false;
      $isBody = $memo->memo_body ? true : false;

      // 「タイトル」か「内容」が未入力だとエラーになるので、
      // 未入力時は配列に入れない。
      if (!$isTitle && !$isBody) continue;

      // タイトルと内容
      if ($isTitle && $isBody) $memoList = array($this->textLimit($memo->memo_title, 15), $this->textLimit($memo->memo_body, 50));

      // 内容のみ
      if (!$isTitle) $memoList = array($this->textLimit($memo->memo_body, 50));

      // タイトルのみ
      if (!$isBody) $memoList = array($this->textLimit($memo->memo_title, 15));

      $memoTextLimitArray[$memo->id] = $memoList;
    }

    return [
      'memos' => $memos,
      'memo_text_limit_array' => $memoTextLimitArray,
    ];
  }
}
