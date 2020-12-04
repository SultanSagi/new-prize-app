<?php

namespace Tests\Feature;

use App\Lottery;
use App\Prize;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrizeTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        $this->withoutExceptionHandling();

        $lottery = factory(Lottery::class)->create([
            'status' => true,
            'total_sum' => 80000
        ]);

        $prize = factory(Prize::class)->create();

        dd($prize);
    }
}
