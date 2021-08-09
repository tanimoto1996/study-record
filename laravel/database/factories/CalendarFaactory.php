<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Calendar;
use Faker\Generator as Faker;

$factory->define(Calendar::class, function (Faker $faker) {
    return [
        // メモデータ作成
        'calendar_body' => $faker->text(20),
        'calendar_field' => 202185,
        'user_id' => function () {
            return factory(User::class);
        }
    ];
});
