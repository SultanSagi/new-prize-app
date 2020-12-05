<?php

namespace App\Http\Controllers;

use App\Lottery;
use App\Prize;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lottery = Lottery::where('status', true)->first();
        $userId = 1;
        $prize = Prize
            ::where('lottery_id', $lottery->id)
            ->where('user_id', $userId)
            ->whereHas('prizeType', function ($prizeType) {
                $prizeType->where('name', 'money');
            });

        dd($prize->get());

        return view('home');
    }
}
