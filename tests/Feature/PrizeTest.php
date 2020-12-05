<?php

namespace Tests\Feature;

use App\Lottery;
use App\Prize;
use App\PrizeType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrizeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_a_prize()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $lottery = factory(Lottery::class)->state('active')->create();

        factory(Prize::class)->create([
            'lottery_id' => $lottery
        ]);

        $this
            ->actingAs($user)
            ->get('prizes');

        $this->assertCount(1, $user->prizes);
    }

    /** @test */
    public function prize_can_be_rejected()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $lottery = factory(Lottery::class)->state('active')->create();

        factory(Prize::class)->create([
            'lottery_id' => $lottery
        ]);

        $this
            ->actingAs($user)
            ->get('prizes');

        $prize = $user->fresh()->prizes->first();

        $this->assertFalse($prize->is_rejected);

        $this->delete("prizes/{$prize->id}");

        $prize = $prize->fresh();

        $this->assertTrue($prize->is_rejected);
    }

    /** @test */
    public function money_prize_can_be_transferred_to_user_account()
    {
        $this->withoutExceptionHandling();

        $lottery = factory(Lottery::class)->state('active')->create();
        $user = factory(User::class)->create();

        $prizeType = factory(PrizeType::class)->create([
            'name' => 'money'
        ]);

        $prize = factory(Prize::class)->create([
            'lottery_id' => $lottery,
            'user_id' => $user,
            'prize_type_id' => $prizeType
        ]);

        $data = [
            'prize_id' => $prize->id,
        ];

        $this->assertSame(0, $user->bank_account_amount);

        $this
            ->actingAs($user)
            ->post('user-account', $data);

        $this->assertSame($prize->prize_amount, $user->fresh()->bank_account_amount);
    }

    /** @test */
    public function money_prize_can_be_converted_to_points()
    {
        $this->withoutExceptionHandling();

        $lottery = factory(Lottery::class)->state('active')->create();
        $user = factory(User::class)->create();

        $prize = factory(Prize::class)->state('money')->create([
            'lottery_id' => $lottery,
            'user_id' => $user,
        ]);

        $data = [
            'prize_id' => $prize->id,
        ];

        $this->assertSame(0, $user->points);

        $this
            ->actingAs($user)
            ->post('money-to-points', $data);

        $this->assertSame((int)($prize->prize_amount * $lottery->rate), $user->fresh()->points);
    }
}
