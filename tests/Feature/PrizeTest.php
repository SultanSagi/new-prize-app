<?php

namespace Tests\Feature;

use App\Lottery;
use App\Prize;
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

        $response = $this
            ->actingAs($user)
            ->post('prizes')
            ->assertOk();

        $response = $response->decodeResponseJson();

        $prize = Prize::latest('id')->first();

        $this->assertEquals($prize->prizeType->name, $response['type']);
        $this->assertEquals($prize->prize_amount, $response['sum']);

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
            ->post('prizes');

        $prize = $user->fresh()->prizes->first();

        $this->assertFalse($prize->is_rejected);

        $this->delete("prizes/{$prize->id}");

        $prize = $prize->fresh();

        $this->assertTrue($prize->is_rejected);
    }
}
