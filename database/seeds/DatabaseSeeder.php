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
//        $lottery = factory(\App\Lottery::class)->create();
        $prizes = factory(\App\Prize::class, 4)->create();
    }
}
