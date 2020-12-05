<?php

namespace App\Http\Controllers;

use App\Prize;
use App\Services\PrizeService;

class PrizesController extends Controller
{
    private $prizeService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PrizeService $prizeService)
    {
        $this->middleware('auth');
        $this->prizeService = $prizeService;
    }

    public function store()
    {
        $prize = $this->prizeService->getPrize(auth()->id());

//        $prizes = ['money', 'bonus points', 'object'];
//
//        $prizeTypeIndex = array_rand($prizes);
//
//        if ($prizes[$prizeTypeIndex] === "object") {
//            $objects = ['Table', 'ball', 'car', 'laptop', 'phone'];
//            $objectIndex = array_rand($objects);
//            $prize = $objects[$objectIndex];
//            $prizeSentence = $prize;
//        }
//        else {
//            $prize = rand(1, 1000);
//            $prizeSentence = "$prize $prizes[$prizeTypeIndex]";
//        }
//
//        return redirect('/home')
//            ->with('success', "Congrats! You won");
        return view('home')
            ->with('success', "Congrats! You won")
            ->with('prize', $prize);
    }

    public function destroy(Prize $prize)
    {
        $response = $this->prizeService->rejectPrize($prize->id);
        return redirect('/home')
            ->with($response['status'], $response['message']);
    }
}
