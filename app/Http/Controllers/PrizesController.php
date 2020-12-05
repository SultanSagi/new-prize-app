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

    public function show()
    {
        $prize = $this->prizeService->getPrize(auth()->id());

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
