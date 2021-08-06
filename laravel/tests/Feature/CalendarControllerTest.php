<?php

namespace Tests\Feature;

use App\Calendar\CalendarView;
use App\Models\User;
use App\Models\Memo;
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
     * ファクトリー作成
     * @test
     */
    // public function testShowTaskDescendingOrder()
    // {
    //     // userの情報を生成して取得
    //     $user = factory(User::class)->create();
    //     // ログイン済みにする
    //     $this->actingAs($user);

    //     $firstPost = factory(Todo::class)->create([
    //         'todo_body' => 'first',
    //         'todo_status' => '0',
    //         'user_id' => $user->id,
    //         'created_at' => '2021-07-20 10:30:00'
    //     ]);

    //     $secondPost = factory(Todo::class)->create([
    //         'todo_body' => 'second',
    //         'todo_status' => '1',
    //         'user_id' => $user->id,
    //         'created_at' => '2021-07-30 10:31:00'
    //     ]);

    //     $thirdPost = factory(Todo::class)->create([
    //         'todo_body' => 'third',
    //         'todo_status' => '0',
    //         'user_id' => $user->id,
    //         'created_at' => '2021-07-20 10:32:00'
    //     ]);

    //     // コントローラーで降順に並び替える
    //     $response = $this->get(action('TodoController@showTodoList'));

    //     // 降順で並んでいるかを確認する
    //     $expects = array($secondPost->todo_body, $thirdPost->todo_body, $firstPost->todo_body);
    //     $response->assertSeeInOrder($expects);
    // }
}
