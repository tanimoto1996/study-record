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
}
