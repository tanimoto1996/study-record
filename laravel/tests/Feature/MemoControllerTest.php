<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MemoControllerTest extends TestCase
{
    use RefreshDatabase;

    // csrf使用
    use WithoutMiddleware;

    /**
     * ログイン時にメモに遷移
     * @test
     */
    public function testAuthMemo()
    {
        // userの情報を取得
        $user = factory(User::class)->create();

        // ログインした状態でTODOのトップページに遷移
        $response = $this->actingAs($user)->get(route('memo.list'));

        // 遷移が成功したらテストコード200を返す
        $response->assertStatus(200)->assertViewIs('memos.list');
    }

    /**
     * メモが問題なく登録できているかのテスト
     * @test
     */
    public function testMemoCreate()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();

        //第二引数にPOST値の配列を渡す
        $response = $this->actingAs($user)->get('/memo/create', [
            'memo_title' => '新規メモ',
            'memo_body' => '',
            'user_id' => $user->id
        ]);

        // post後にTODO画面に遷移する
        $response = $this->get('/memo');

        // 遷移が成功すると200ステータスを返す
        $response->assertStatus(200);

        // POSTした「新規メモ」文字があればテスト成功
        $response->assertSee("新規メモ");
    }

    /**
     * 一覧画面にメモがupdate順に表示されているか
     * @test
     */
    public function testShowMemoUpdateOrder()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();
        // ログイン済みにする
        $this->actingAs($user);

        $firstPost = factory(Memo::class)->create([
            'memo_title' => 'first',
            'memo_body' => '最初のメモ',
            'user_id' => $user->id,
            'updated_at' => '2021-07-21 10:30:00'
        ]);

        $secondPost = factory(Memo::class)->create([
            'memo_title' => 'second',
            'memo_body' => '２つ目のメモ',
            'user_id' => $user->id,
            'updated_at' => '2021-07-23 10:30:00'
        ]);

        $thirdPost = factory(Memo::class)->create([
            'memo_title' => 'third',
            'memo_body' => '3つ目のメモ',
            'user_id' => $user->id,
            'updated_at' => '2021-07-22 10:30:00'
        ]);

        // コントローラーでupdate順に並び替える
        $response = $this->get(action('MemoController@showMemoList'));

        // 編集順で並んでいるかを確認する
        $expects = array($secondPost->memo_body, $thirdPost->memo_body, $firstPost->memo_body);
        $response->assertSeeInOrder($expects);
    }
}
