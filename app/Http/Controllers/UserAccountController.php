<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class UserAccountController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
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
}
