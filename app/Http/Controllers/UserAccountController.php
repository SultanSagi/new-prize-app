<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\PrizeService;

class UserAccountController extends Controller
{
    private $userRepository;

    private $prizeService;

    public function __construct(UserRepository $userRepository, PrizeService $prizeService)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->prizeService = $prizeService;
    }

    public function store()
    {
        request()->validate([
            'prize_id' => 'required|exists:prizes,id',
        ]);

        $this->userRepository->depositIntoAccount(auth()->id(), request('prize_id'));

        return redirect('/home')
            ->with('success', "Successfully transferred to your bank account");
    }

    public function convertMoneyToPoints()
    {
        request()->validate([
            'prize_id' => 'required|exists:prizes,id',
        ]);

        $response = $this->prizeService->convertMoneyToPoints(auth()->id(), request('prize_id'));

        return redirect('/home')
            ->with($response['status'], $response['message']);
    }
}
