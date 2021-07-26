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

        // todo
        $tasks = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // memo
        $memos = Memo::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

        // UNIX TIMESTAMPを取得
        $timeStamp = time();
        // 本日の年月日を取得
        $date = date("Ynd", $timeStamp);

        // calendar
        $calendar = Calendar::where('user_id', Auth::id())->where('calendar_field', $date)->first();

        // study_times
        $times = StudyTime::where('user_id', Auth::id())->get();

        $total = 0;
        foreach ($times as $time) {
            $total += $time->time;
        }

        if ($total) {
            $total = substr_replace($total, '時間', mb_strlen($total) - 2, 0);
        }

        return view('top', [
            'tasks' => $tasks,
            'memos' => $memos,
            'calendar' => $calendar,
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
}
