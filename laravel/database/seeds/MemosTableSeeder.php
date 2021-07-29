<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Memosのダミーデータを生成する
        for ($i = 1; $i <= 5; $i++) {
            DB::table('memos')->insert([
                'memo_title' => Str::random(10),
                'memo_body' => Str::random(30),
                'user_id' => 7,
            ]);
        }
    }
}
