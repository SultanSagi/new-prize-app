<?php


namespace App\Services;


use App\Prize;
use App\PrizeItem;
use App\PrizeType;
use App\Repositories\LotteryRepository;
use App\Repositories\PrizeRepository;
use Illuminate\Support\Facades\Auth;

class PrizeService
{
    private $prizeRepository;

    private $prizeTypeRepository;

    private $currentLottery;

    private $availableMoney = null;

    private $prizeTypeArray = [
        'bonuses',
    ];

    private $availableProducts = [];

    const PRIZE_TITLE = [
        'bonuses' => 'Bonus points',
        'money' => 'Money',
        'product' => 'Product',
    ];

    public function __construct(
        LotteryRepository $lotteryRepository,
        PrizeRepository $prizeRepository
    )
    {
        $this->currentLottery = $lotteryRepository->findActive();
        $this->prizeRepository = $prizeRepository;
        $this->availableMoney = $this->checkAvailableMoney();

        if($this->availableMoney > 0) {
            array_push($this->prizeTypeArray, 'money');
        }
        $this->availableProducts = $this->checkAvailableProducts();
        if(count($this->availableProducts) > 0) {
            array_push($this->prizeTypeArray, 'product');
        }
    }

    private function checkAvailableMoney()
    {
        $totalMoney = $this->currentLottery->total_sum;
        $spentMoney = $this->prizeRepository->findSumMoneyPrizeByLottery($this->currentLottery->id);
        return (int)$totalMoney - (int)$spentMoney;
    }

    private function checkAvailableProducts()
    {
        return $this->prizeRepository->findAvailableProductsByLottery($this->currentLottery->id);
    }

    public function getPrize(int $userId)
    {
        $prizeKey = array_rand($this->prizeTypeArray);

        $prizeType = PrizeType::where('name', $this->prizeTypeArray[$prizeKey])->first();

        $prizeSum = null;
        $prizeItem = null;

        switch ($this->prizeTypeArray[$prizeKey]){
            case 'bonuses':
                $min = 0;
                $max = 1000;
                $prizeSum = $this->getRandomAmount($min, $max);
                break;
            case 'money':
                $min = 0;
                $max = 1000;
                $prizeSum = $this->getRandomAmount($min, $max);
                break;
            case 'product':
                $prizeItem = $this->getRandomProducts();
                break;
        }

        $prize = Prize::create([
            'user_id' => $userId,
            'lottery_id' => $this->currentLottery->id,
            'prize_type_id' => $prizeType ? $prizeType->id : 1,
            'prize_amount' => $prizeSum,
            'prize_item_id' => $prizeItem ? $prizeItem->id: null
        ]);

        return $prize->toArray();
    }

    private function getRandomAmount(int $min, int $max):int
    {
        return random_int($min, $max);
    }

    private function getRandomProducts():PrizeItem
    {
        $index = array_rand($this->availableProducts);
        return PrizeItem::where('name', $this->availableProducts[$index])->first();
    }

    public function rejectPrize(int $id):array
    {
        $response = [];

        $prize = Prize::find($id);
        if(!$prize){
            $response['status'] = 'error';
            $response['message'] = 'Prize not found!';
            return $response;
        }
        if($prize->is_rejected) {
            $response['status'] = 'error';
            $response['message'] = 'Prize already was rejected!';
            return $response;
        }

        $prize->reject();

        $response['status'] = 'success';
        $response['message'] = 'Prize was successfully rejected!';
        return $response;
    }
}