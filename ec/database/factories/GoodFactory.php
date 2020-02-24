<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Good;
use Faker\Generator as Faker;

$factory->define(Good::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'kana' => $faker->name,
        'category_id' => $faker->randomDigit(),
        'maker_id' => $faker->randomDigit(),
        'price' => $faker->numberBetween(100, 20000),
        'stock' => $faker->randomDigit(),
        'good_details' => $faker->paragraph(),
    ];
});
