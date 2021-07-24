<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// トップページ
Route::get('/', function () {
    return view('top');
});

// TODO
Route::prefix('todo')->name('todo.')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'TodoController@showTodoList')->name('list');
        Route::post('/', 'TodoController@taskCreate')->name('create');
        Route::patch('/{task_id}', 'TodoController@taskUpdate')->name('update');
        Route::delete('/{task_id}', 'TodoController@taskDelete')->name('delete');
        route::post('/{task_id}/statusUpdate', 'TodoController@taskStatusUpdate')->name('statusUpdate');
    });
});

// メモ
Route::prefix('memo')->name('memo.')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'MemoController@showMemoList')->name('list');
        Route::get('/create', 'MemoController@memoCreate')->name('create');
        Route::get('/select', 'MemoController@memoSelect')->name('select');
        Route::post('/update', 'MemoController@memoUpdate')->name('update');
        Route::post('/delete', 'MemoController@memoDelete')->name('delete');
    });
});

// カレンダー
Route::prefix('calendar')->name('calendar.')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'CalendarController@showCalendar')->name('index');
        Route::get('/edit', 'CalendarController@calendarEdit')->name('edit');
        Route::post('/create', 'CalendarController@calendarCreate')->name('create');
        Route::post('/update', 'CalendarController@calendarUpdate')->name('update');
    });
});

// 認証
Auth::routes();
