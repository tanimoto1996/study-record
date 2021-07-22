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

        return view("memos.list", [
            'memos' => $memos,
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
}
