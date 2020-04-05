<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(['open', 'close']),
        'answered' => $faker->randomElement(['user', 'manager']),
        'view' => $faker->randomElement([true, false]),
        'subject' => $faker->text(random_int(30, 125))
    ];
});
