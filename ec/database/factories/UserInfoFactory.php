<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

// $factory->define(Model::class, function (Faker $faker) {
//     return [
//         //
//     ];
// });

$factory->define(App\UserInfo::class, function (Faker $faker) {
    return [
        'user_id' => 10,
        'name' => $faker->name,
        'zip' => 898922,
        'address' => $faker->address,
        'tel' => 07000001111,
    ];
});