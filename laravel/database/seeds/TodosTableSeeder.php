<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Todosのダミーデータを生成する
        for ($i = 1; $i <= 5; $i++) {
            DB::table('todos')->insert([
                'todo_body' => Str::random(10),
                'todo_status' => 0,
                'user_id' => 7,
            ]);
        }
    }
}
