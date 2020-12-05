<?php

namespace Tests\Feature;

use App\Lottery;
use App\Prize;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotteryTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        $activeLottery = factory(Lottery::class)->state('active')->create();
        $inactiveLottery = factory(Lottery::class)->state('inactive')->create();

        $this->get('lotteries')
            ->assertSee($activeLottery->total_sum)
            ->assertDontSee($inactiveLottery->total_sum);

    }
}
