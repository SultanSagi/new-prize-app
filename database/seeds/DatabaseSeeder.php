<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $lottery = factory(\App\Lottery::class)->state('active')->create([
            'total_sum' => 1000
        ]);

        factory(\App\PrizeItem::class)->create([
            'name' => 'car',
            'lottery_id' => $lottery->id,
        ]);

        factory(\App\PrizeItem::class)->create([
            'name' => 'phone',
            'lottery_id' => $lottery->id,
        ]);

        factory(\App\PrizeItem::class)->create([
            'name' => 'motorbike',
            'lottery_id' => $lottery->id,
        ]);

        factory(\App\PrizeType::class)->create([
            'name' => 'bonuses',
        ]);

        factory(\App\PrizeType::class)->create([
            'name' => 'money',
        ]);

        factory(\App\PrizeType::class)->create([
            'name' => 'product',
        ]);

        factory(\App\User::class)->create([
            'email' => 'john@example.org',
        ]);
    }
}
