<?php

namespace Tests\Feature;

use App\Lottery;
use App\Prize;
use App\PrizeType;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendMoneyPrizesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_a_prize()
    {
        $this->withoutExceptionHandling();

        $lottery = factory(Lottery::class)->state('active')->create();
        $user = factory(User::class)->create();

        $prizeType = factory(PrizeType::class)->create([
            'name' => 'money'
        ]);

        factory(Prize::class, 4)->create([
            'lottery_id' => $lottery,
            'user_id' => $user,
            'prize_type_id' => $prizeType,
            'is_rejected' => false
        ]);

        $expectedCount = 2;

        Artisan::call("send:money-prizes {$user->id} {$expectedCount}");

        $this->assertCount($expectedCount, $user->fresh()->prizes()->whereNotNull('sent_at')->get());
    }
}
