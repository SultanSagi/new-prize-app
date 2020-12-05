<?php


namespace App\Repositories;


use App\Lottery;

class LotteryRepository
{
    public function findActive()
    {
        return Lottery::where('status', true)->first();
    }
}