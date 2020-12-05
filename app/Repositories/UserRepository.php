<?php


namespace App\Repositories;


use App\Prize;
use App\User;

class UserRepository
{
    public function depositIntoAccount($userId, $prizeId)
    {
        $user = User::find($userId);

        if(!$user) {
            throw new \Exception("User not found");
        }

        $prize = Prize::find($prizeId);

        $user->update([
            'bank_account_amount' => $user->bank_account_amount + $prize->prize_amount
        ]);
    }
}