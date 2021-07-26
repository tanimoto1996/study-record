<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;
    // csrf使用
    use WithoutMiddleware;

    /**
     * ログイン時にTODOに遷移
     * @test
     */
    public function testAuthTodo()
    {
        // userの情報を取得
        $user = factory(User::class)->create();

        // ログインした状態でTODOのトップページに遷移
        $response = $this->actingAs($user)->get(route('todo.list'));

        // 遷移が成功したらテストコード200を返す
        $response->assertStatus(200)->assertViewIs('todos.list');
    }

    /**
     * タスクが問題なく登録できているかのテスト
     * @test
     */
    public function testTaskCreate()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();

        //第二引数にPOST値の配列を渡す
        $response = $this->actingAs($user)->post('/todo', [
            'todo_body' => 'テスト',
            'todo_status' => '0',
            'user_id' => $user->id
        ]);

        //登録処理が完了して、一覧画面にリダイレクトすることを検証
        $response->assertRedirect(route('todo.list'));
    }
}