<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    // メモトップ画面
    public function showMemoList(Memo $memos)
    {
        $memos = $memos->where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

        $memoTextLimitArray = array();
        foreach ($memos as $memo) {
            // 表示文字数を制限するために再度配列に格納し直す
            $memoList = array(TopController::textLimit($memo->memo_title, 15), TopController::textLimit($memo->memo_body, 50));
            $memoTextLimitArray[$memo->id] = $memoList;
        }

        return view("memos.list", [
            'memos' => $memos,
            'memo_text_limit_array' => $memoTextLimitArray,
            'select_memo' => session()->get('select_memo'),
        ]);
    }

    // メモ作成
    public function memoCreate(Memo $memos)
    {
        $memos->create([
            'memo_title' => '新規メモ',
            'memo_body' => '',
            'user_id' => Auth::id()
        ]);

        return redirect()->route('memo.list');
    }

    // メモ選択
    public function memoSelect(Memo $memos, Request $request)
    {
        $memo = $memos->find($request->id);

        session()->put('select_memo', $memo);

        return redirect()->route('memo.list');
    }

    // メモ更新
    public function memoUpdate(Memo $memos, Request $request)
    {
        $memo = $memos->find($request->edit_id);

        $memo->memo_title = $request->edit_title;
        $memo->memo_body = $request->edit_body;
        $memo->save();

        session()->put('select_memo', $memo);

        return redirect()->route('memo.list');
    }

    // メモ削除
    public function memoDelete(Memo $memos, Request $request)
    {
        $memo = $memos->find($request->edit_id);
        $memo->delete();

        session()->remove('select_memo');

        return redirect()->route('memo.list');
    }

    // 文字数制限
    public static function textLimit($text, $limit = 15)
    {
        $todoText = $text;
        if (mb_strlen($text) > $limit) {
            // 文字の末尾に「・・・」をつける
            $text = mb_substr($text, 0, $limit) . "…";
        }

        return $text;
    }
}
