<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use App\Prize;
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

$factory->define(Prize::class, function (Faker $faker) {
    $prizeType = factory(\App\PrizeType::class)->create([
        'name' => 'bonuses'
    ]);
    return [
        'lottery_id' => factory(\App\Lottery::class),
        'user_id' => factory(User::class),
        'prize_type_id' => $prizeType,
        'prize_item_id' => null,
        'prize_amount' => $faker->numberBetween(1,1000),
        'is_rejected' => false
    ];
});

$factory->state(Prize::class, 'money', function () {
    $prizeType = factory(\App\PrizeType::class)->create([
        'name' => 'money'
    ]);
    return [
        'prize_type_id' => $prizeType,
    ];
});

$factory->state(Prize::class, 'product', function () {
    $prizeType = factory(\App\PrizeType::class)->create([
        'name' => 'product'
    ]);
    return [
        'prize_type_id' => $prizeType,
        'prize_amount' => null,
        'prize_item_id' => factory(\App\PrizeItem::class),
    ];
});
