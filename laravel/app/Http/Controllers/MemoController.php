<?php

namespace App\Http\Controllers;

use App\lib\helperFunctions;
use App\Models\Memo;
use App\Memo\UseCase\ShowMemoListUseCase;
use App\Http\Requests\CreateMemoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{

    use helperFunctions;

    /**
     * メモ一覧画面
     * @param App\Memo\UseCase\ShowMemoListUseCase $useCase
     * @return Response
     */
    public function showMemoList(ShowMemoListUseCase $useCase)
    {
        return view("memos.list", [
            'select_memo' => session()->get('select_memo'),
        ] + $useCase->handle());
    }

    /**
     * メモ作成
     * @param App\Models\Memo $memos
     * @return Response
     */
    public function memoCreate(Memo $memos)
    {
        $memos->create([
            'memo_title' => '新規メモ',
            'memo_body' => '',
            'user_id' => Auth::id()
        ]);

        return redirect()->route('memo.list');
    }

    /**
     * メモ選択
     * セッションでどのメモを選択しているかの情報を保持する
     * @param App\Models\Memo $memos
     * @param App\Http\Requests\CreateMemoRequest $request
     * @return Response
     */
    public function memoSelect(Memo $memos, CreateMemoRequest $request)
    {
        $memo = $memos->find($request->id);

        session()->put('select_memo', $memo);

        return redirect()->route('memo.list');
    }

    /**
     * メモ更新
     * セッションで更新後のメモを選択する
     * @param App\Models\Memo $memos
     * @param App\Http\Requests\CreateMemoRequest $request
     * @return Response
     */
    public function memoUpdate(Memo $memos, CreateMemoRequest $request)
    {
        $memo = $memos->find($request->edit_id);

        $memo->update([
            'memo_title' => $request->edit_title,
            'memo_body' => $request->edit_body,
        ]);

        session()->put('select_memo', $memo);

        return redirect()->route('memo.list');
    }

    /**
     * メモ削除
     * セッションも削除
     * @param App\Models\Memo $memos
     * @param App\Http\Requests\CreateMemoRequest $request
     * @return Response
     */
    public function memoDelete(Memo $memos, CreateMemoRequest $request)
    {
        $memo = $memos->find($request->edit_id);
        $memo->delete();

        session()->remove('select_memo');

        return redirect()->route('memo.list');
    }
}
