<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyTime;
use App\Top\UseCase\ShowTopPageUseCase;
use App\Http\Requests\CreateStudyTimeRequest;

class TopController extends Controller
{
    /**
     * TOP画面
     * @param array $useCase TOPページに関するDBから必要なデータ取得
     * @return Response
     */
    public function showTop(ShowTopPageUseCase $useCase)
    {
        return view('top', $useCase->handle());
    }

    /**
     * 学習時間の更新
     * @param App\Models\StudyTime $times
     * @param App\Http\Requests\CreateStudyTimeRequest $request
     * @return Response
     */
    public function studyTimeCreate(StudyTime $times, CreateStudyTimeRequest $request)
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
