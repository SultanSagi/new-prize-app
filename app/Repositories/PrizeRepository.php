<?php


namespace App\Repositories;


use App\Prize;
use App\PrizeItem;

class PrizeRepository
{
    public function findSumMoneyPrizeByLottery(int $id)
    {
         $prize = Prize::where('lottery_id', $id)
            ->where('is_rejected', false)
            ->whereNotNull('user_id')
            ->first();


        return $prize ? $prize->prize_amount : 0;
    }

    public function findAvailableProductsByLottery(int $id)
    {
        $prizes = Prize::where('lottery_id', $id)
            ->whereNotNull('prize_item_id')
            ->where('is_rejected', false)
            ->pluck('prize_item_id');

        return PrizeItem::where('lottery_id', $id)
            ->whereNotIn('id', $prizes)
            ->pluck('name', 'id')
            ->toArray();
    }
}