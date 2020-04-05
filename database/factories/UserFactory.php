<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make(Str::random(8)),
        'role' => 'user',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
$factory->state(User::class,'manager', function (Faker $faker) {
    return [
        'email' => 'manager@mail.ru',
        'password' => Hash::make(12345),
        'role' => 'manager',
    ];
});
$factory->state(User::class,'user', function (Faker $faker) {
    return [
        'email' => 'user@mail.ru',
        'password' => Hash::make(54321),
        'role' => 'user',
    ];
});
