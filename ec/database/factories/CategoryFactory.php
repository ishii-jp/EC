<?php

/**
 * CategoryFactoryは作成したものの使わなくなったため、一度も動かしていないです。
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'category_name' => $faker->name
    ];
});
