<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Todo;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        // TODOデータの作成
        'todo_body' => $faker->text(20),
        'todo_status' => $faker->randomElement([0, 1]),
        'user_id' => function () {
            return factory(User::class);
        }
    ];
});
