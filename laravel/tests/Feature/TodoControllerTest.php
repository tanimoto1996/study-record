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
        $this->actingAs($user)->post('/todo', [
            'todo_body' => 'テスト',
            'todo_status' => '0',
            'user_id' => $user->id
        ]);

        // post後にTODO画面に遷移する
        $response = $this->get('/todo');

        // 遷移が成功すると200ステータスを返す
        $response->assertStatus(200);

        // POSTした「テスト」文字があればテスト成功
        $response->assertSee("テスト");
    }

    /**
     * 一覧画面にタスクが降順に表示されているか
     * @test
     */
    public function testShowTaskDescendingOrder()
    {
        // userの情報を生成して取得
        $user = factory(User::class)->create();
        // ログイン済みにする
        $this->actingAs($user);

        $firstPost = factory(Todo::class)->create([
            'todo_body' => 'first',
            'todo_status' => '0',
            'user_id' => $user->id,
            'created_at' => '2021-07-20 10:30:00'
        ]);

        $secondPost = factory(Todo::class)->create([
            'todo_body' => 'second',
            'todo_status' => '1',
            'user_id' => $user->id,
            'created_at' => '2021-07-30 10:31:00'
        ]);

        $thirdPost = factory(Todo::class)->create([
            'todo_body' => 'third',
            'todo_status' => '0',
            'user_id' => $user->id,
            'created_at' => '2021-07-20 10:32:00'
        ]);

        // コントローラーで降順に並び替える
        $response = $this->get(action('TodoController@showTodoList'));

        // 降順で並んでいるかを確認する
        $expects = array($secondPost->todo_body, $thirdPost->todo_body, $firstPost->todo_body);
        $response->assertSeeInOrder($expects);
    }

    /**
     * 投稿した内容を更新する
     * @test
     */
    public function testPostUpdate()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $item = factory(Todo::class)->create([
            'user_id' => $user->id,
            'todo_body' => 'editTest',
        ]);

        factory(Todo::class)->create([
            'user_id' => $user->id,
            'todo_body' => 'notEditTest',
        ]);
        $task_id = $item->id;
        $task_body = "変更しています";
        $data = [$task_id => $item->id, $task_body => "変更しています"];

        $this->get(action('TodoController@showTodoList', $data));
        $this->assertDatabaseHas('todos', [
            'todo_body' => '変更しています',
        ]);
    }
}
