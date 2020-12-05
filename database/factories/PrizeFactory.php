<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
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

$factory->define(\App\Prize::class, function (Faker $faker) {
    $prizeTypes = ['bonuses','money','product'];
    $prizeType = factory(\App\PrizeType::class)->create([
        'name' => $faker->randomElement($prizeTypes)
    ]);
    return [
        'lottery_id' => factory(\App\Lottery::class),
        'user_id' => factory(User::class),
        'prize_type_id' => $prizeType,
        'prize_item_id' => factory(\App\PrizeItem::class),
        'prize_amount' => $faker->numberBetween(1,1000),
        'is_rejected' => false
    ];
});
