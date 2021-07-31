<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarView;
use App\Models\Calendar;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    // カレンダートップ画面表示
    public function showCalendar(Request $request)
    {
        //クエリーのdateを受け取る
        $date = $request->input("date");

        // udpate時の月に戻す
        if (isset($request->paramDate)) $date = $request->paramDate;

        //dateがYYYY-MMの形式かどうか判定する
        if ($date && preg_match("/^[0-9]{4}-[0-9]{2}$/", $date)) {
            $date = strtotime($date . "-02");
        } else {
            $date = null;
        }

        //取得出来ない時は現在(=今月)を指定する
        if (!$date) $date = time();

        $calendar = new CalendarView($date);

        return view('calendars.index', [
            'calendar' => $calendar,
        ]);
    }

    // カレンダーモーダル表示
    public function calendarEdit(Request $request)
    {
        $calendar = Calendar::where('user_id', Auth::id())->where('calendar_field', $request->calendar_id)->first();

        // クリックし日付の内容を返す
        return view('calendars.edit', [
            'calendar' => $calendar,
            'id' => $request->calendar_id,
            'title' => $request->title,
            'paramDate' => $request->parameter_date,
        ]);
    }

    // 予定作成
    public function calendarCreate(Calendar $calendars, Request $request)
    {;
        $calendars->calendar_body = $request->calendar_body;
        $calendars->calendar_field = $request->calendar_field;
        $calendars->user_id = Auth::id();
        $calendars->save();

        // カレンダー、一覧に戻る ここでURLパラメーターを見て,calendar.indexに投げる
        return redirect()->route('calendar.index', ['paramDate' => $request->param_date]);
    }

    // 予定更新
    public function calendarUpdate(Calendar $calendars, Request $request)
    {
        $calendar = Calendar::where('user_id', Auth::id())->where('calendar_field', $request->calendar_field)->first();

        $calendar->calendar_body = $request->calendar_body;
        $calendar->calendar_field = $request->calendar_field;
        $calendar->user_id = Auth::id();
        $calendar->save();

        // カレンダー、一覧に戻る
        return redirect()->route('calendar.index', ['paramDate' => $request->param_date]);
    }
}
