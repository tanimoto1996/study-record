<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// TOPページ
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

// MEMO
Route::prefix('memo')->name('memo.')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'MemoController@showMemoList')->name('list');
    });
});

// 認証
Auth::routes();
