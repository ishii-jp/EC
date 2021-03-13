<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PurchaseHistory;
use Faker\Generator as Faker;

$factory->define(PurchaseHistory::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,10),
        'good_id' => $faker->numberBetween(1,100),
        'qty' => $faker->randomDigit()
    ];
});
