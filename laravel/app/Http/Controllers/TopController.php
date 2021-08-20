<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyTime;
use App\Top\UseCase\ShowTopPageUseCase;
use App\Top\UseCase\createStudyTimeUseCase;
use App\Http\Requests\CreateStudyTimeRequest;

class TopController extends Controller
{
    /**
     * TOP画面
     * @param array $useCase TOPページに関するDBから必要なデータ取得
     * @return Response
     */
    public function showTop(ShowTopPageUseCase $useCase, Request $reauest)
    {
        if (isset($reauest->month)) {
            // 1ヶ月の学習時間を表示する
            $month = $reauest->month;
        } else {
            $month = 0;
        }


        return view('top', [
            'error_time' => session()->get('error_time'),
        ] + $useCase->handle($month));
    }

    /**
     * 学習時間の更新
     * @param App\Models\StudyTime $times
     * @param App\Http\Requests\CreateStudyTimeRequest $request
     * @param App\Top\UseCase\ShowTopPageUseCase $useCase
     * @return Response
     */
    public function studyTimeCreate(StudyTime $times, CreateStudyTimeRequest $request, createStudyTimeUseCase $useCase)
    {
        $useCase->handle($times, $request);
        return redirect()->route('top');
    }
}
