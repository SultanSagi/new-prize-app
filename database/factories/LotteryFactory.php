<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Lottery;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Generator as Faker;

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

$factory->define(\App\Lottery::class, function (Faker $faker) {
    return [
        'started_at' => Carbon::now(),
        'finished_at' => Carbon::now(),
        'status' => false,
        'total_sum' => $faker->numberBetween(1,1000),
        'rate' => $faker->numberBetween(1,100),
    ];
});

$factory->state(\App\Lottery::class, 'active', function () {
    return [
        'status' => true
    ];
});

$factory->state(\App\Lottery::class, 'inactive', function () {
    return [
        'status' => false
    ];
});
