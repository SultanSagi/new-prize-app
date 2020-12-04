<?php

namespace App\Http\Controllers;

class PrizesController extends Controller
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

    public function store()
    {
        $prizes = ['money', 'bonus points', 'object'];

//        $prize = "";

//        $prizeSentence = "";

        $prizeTypeIndex = array_rand($prizes);

        if ($prizes[$prizeTypeIndex] === "object") {
            $objects = ['Table', 'ball', 'car', 'laptop', 'phone'];
            $objectIndex = array_rand($objects);
            $prize = $objects[$objectIndex];
            $prizeSentence = $prize;
        }
        else {
            $prize = rand(1, 1000);
            $prizeSentence = "$prize $prizes[$prizeTypeIndex]";
        }

        return redirect('/home')
            ->with('success', "Congrats! You won - {$prizeSentence}");
    }
}
