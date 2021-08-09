<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    // csrf使用
    use WithoutMiddleware;

    /**
     * ログイン時にカレンダーに遷移
     * @test
     */
    public function testAuthCalendar()
    {
        // userの情報を取得
        $user = factory(User::class)->create();

        // ログインした状態でTODOのトップページに遷移
        $response = $this->actingAs($user)->get(route('calendar.index'));

        // 遷移が成功したらテストコード200を返す
        $response->assertStatus(200)->assertViewIs('calendars.index');
    }

    /**
     * 予定（コメント）が問題なく登録できているかのテスト
     * @test
     */
    public function testCalendarCreate()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();

        //第二引数にPOST値の配列を渡す
        $response = $this->actingAs($user)->post('/calendar/create', [
            'calendar_body' => '今日は英語を勉強する',
            'calendar_field' => '2021826',
            'user_id' => $user->id
        ]);

        //登録処理が完了して、一覧画面にリダイレクトすることを検証
        $response->assertRedirect(route('calendar.index'));
    }

    /**
     * 一覧画面に予定が表示されているか
     * @test
     */
    public function testShowTaskDescendingOrder()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();
        // ログイン済みにする
        $this->actingAs($user);

        $firstPost = factory(calendar::class)->create([
            'calendar_body' => '最初のメモ',
            'calendar_field' => 202185,
            'user_id' => $user->id
        ]);

        $secondPost = factory(calendar::class)->create([
            'calendar_body' => '２つ目のメモ',
            'calendar_field' => 202186,
            'user_id' => $user->id
        ]);

        $thirdPost = factory(calendar::class)->create([
            'calendar_body' => '3つ目のメモ',
            'calendar_field' => 202187,
            'user_id' => $user->id
        ]);

        // コントローラーでカレンダーを表示
        $response = $this->get(action('CalendarController@showCalendar'));

        // カレンダー一覧にPOSTした文字列が表示されているか
        $response->assertSeeText($firstPost->calendar_body, $secondPost->calendar_body, $thirdPost->calendar_body);
    }
}
