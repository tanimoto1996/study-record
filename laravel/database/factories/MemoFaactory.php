<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Memo;
use Faker\Generator as Faker;

$factory->define(Memo::class, function (Faker $faker) {
    return [
        // メモデータ作成
        'memo_title' => $faker->text(20),
        'memo_body' => $faker->text(20),
        'user_id' => function () {
            return factory(User::class);
        }
    ];
});
