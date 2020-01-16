<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\UserInfo::class, function (Faker $faker) {
    return [
        'user_id' => 10,
        'name' => $faker->name,
        'zip' => $faker->postcode,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber,
    ];
});