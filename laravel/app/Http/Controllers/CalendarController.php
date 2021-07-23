<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarView;

class CalendarController extends Controller
{
    // カレンダートップ画面
    public function showCalendar()
    {
        $calendar = new CalendarView(time());

        return view('calendars.index', [
            'calendar' => $calendar,
        ]);
    }

    // カレンダー編集
    public function calendarEdit(Request $request)
    {
        var_dump($request->calendar_id);

        return redirect()->route('calendar.index');
    }
}
