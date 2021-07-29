<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\Todo;
use App\Models\Calendar;
use App\Models\StudyTime;

class TopController extends Controller
{
    public function showTop()
    {

        // todo 上位５件表示 ここでtaskのコメント数制限するのはあり
        $tasks = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();
        $taskBodyArray = array();
        foreach ($tasks as $task) {
            // 表示文字数を制限するために再度配列に格納し直す
            $taskBodyArray[] = TopController::textLimit($task->todo_body, 20);
        }

        // memo 上位５件表示 ここでタイトル数制限するのはあり
        $memos = Memo::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->take(5)->get();
        $memoTitleArray = array();
        foreach ($memos as $memo) {
            // 表示文字数を制限するために再度配列に格納し直す
            $memoTitleArray[] = TopController::textLimit($memo->memo_title, 20);
        }

        // UNIX TIMESTAMPを取得
        $timeStamp = time();
        // 本日の年月日を取得
        $date = date("Ynd", $timeStamp);

        // calendar
        $calendar = Calendar::where('user_id', Auth::id())->where('calendar_field', $date)->first();
        // 表示文字数を制限するために再度変数に格納し直す
        $calendarBody = TopController::textLimit($calendar->calendar_body, 150);

        // study_times
        $times = StudyTime::where('user_id', Auth::id())->get();

        $total = 0;
        foreach ($times as $time) {
            // 全ての時間を合計して代入
            $total += $time->time;
        }

        if ($total) {
            $total = substr_replace($total, '時間', mb_strlen($total) - 2, 0);
        }

        return view('top', [
            'tasks' => $taskBodyArray,
            'memos' => $memoTitleArray,
            'calendar' => $calendarBody,
            'total' => $total
        ]);
    }

    public function studyTimeCreate(StudyTime $times, Request $request)
    {
        // timeカラムがint型のためコロンを排除する
        $time = str_replace(":", "", $request->study_time);

        $times->create([
            'time' => (int)$time,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('top');
    }


    // TODO https://stackoverflow.com/questions/32870243/call-to-undefined-function-app-http-controllers-function-name
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
