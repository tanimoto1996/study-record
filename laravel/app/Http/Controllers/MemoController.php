<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemoController extends Controller
{
    // memoトップ画面
    public function showMemoList()
    {
        return view("memos.list");
    }
}
