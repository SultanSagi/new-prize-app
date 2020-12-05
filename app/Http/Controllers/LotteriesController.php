<?php

namespace App\Http\Controllers;

use App\Repositories\LotteryRepository;

class LotteriesController extends Controller
{
    private $lotteryRepository;

    public function __construct(LotteryRepository $lotteryRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
    }

    public function index()
    {
        $activeLotteries = $this->lotteryRepository->findActive();

        return $activeLotteries;
    }
}
