<?php

namespace App\Http\Controllers;

use App\Calendar\CalendarView;
use App\Calendar\CalendarWeekView;
use App\Models\Calendar;
use App\Calendar\UseCase\ShowCalendarUseCase;
use App\Calendar\UseCase\ShowWeekCalendarUseCase;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCalendarRequest;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * カレンダートップ画面表示
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Calendar\UseCase\ShowCalendarUseCase $useCase
     * @return Request
     */
    public function showCalendar(Request $request, ShowCalendarUseCase $useCase)
    {
        //クエリーのdateを受け取る
        $param = $request->input("date") ?? '';

        // 更新した時の月に戻す
        if (isset($request->paramDate)) $param = $request->paramDate;

        $date = $useCase->handle($param);

        $calendar = new CalendarView($date);

        return view('calendars.index', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * 週カレンダートップ画面表示
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Calendar\UseCase\ShowCalendarUseCase $useCase
     * @return Request
     */
    public function showCalendarWeek(Request $request, ShowWeekCalendarUseCase $useCase)
    {
        //クエリーのdateを受け取る
        $param = $request->input("date") ?? '';

        $date = $useCase->handle($param);

        $calendar = new CalendarWeekView($date);

        return view('calendars.week', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * カレンダーモーダル表示
     * 
     * @param App\Models\Calendar $calendars
     * @param Illuminate\Http\Request $request
     * @return Request
     */
    public function calendarEdit(Calendar $calendars, Request $request)
    {
        $calendar = $calendars->where('user_id', Auth::id())->where('calendar_field', $request->calendar_id)->first();

        // クリックし日付の内容を返す
        return view('calendars.edit', [
            'calendar' => $calendar,
            'id' => $request->calendar_id,
            'title' => $request->title,
            'paramDate' => $request->parameter_date,
        ]);
    }

    /**
     * 予定作成
     * 
     * @param App\Models\Calendar $calendars
     * @param Illuminate\Http\Request $request
     * @return Request
     */
    public function calendarCreate(Calendar $calendars, CreateCalendarRequest $request)
    {;
        $calendars->create([
            'calendar_body' => $request->calendar_body,
            'calendar_field' => $request->calendar_field,
            'user_id' => Auth::id()
        ]);

        // カレンダー、一覧に戻る ここでURLパラメーターを見て,calendar.indexに投げる
        return redirect()->route('calendar.index', ['paramDate' => $request->param_date]);
    }

    /**
     * 予定更新
     * 
     * @param App\Models\Calendar $calendars
     * @param Illuminate\Http\Request $request
     * @return Request
     */
    public function calendarUpdate(Calendar $calendars, CreateCalendarRequest $request)
    {
        $calendar = $calendars->where('user_id', Auth::id())->where('calendar_field', $request->calendar_field)->first();

        $calendar->update([
            'calendar_body' => $request->calendar_body,
            'calendar_field' => $request->calendar_field,
        ]);

        // カレンダー、一覧に戻る
        return redirect()->route('calendar.index', ['paramDate' => $request->param_date]);
    }
}
