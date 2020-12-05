<?php

namespace App\Console\Commands;

use App\Repositories\LotteryRepository;
use App\Repositories\PrizeRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMoneyPrizesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:money-prizes {user_id} {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send money prizes';

    private $lotteryRepository;
    private $prizeRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LotteryRepository $lotteryRepository, PrizeRepository $prizeRepository)
    {
        parent::__construct();

        $this->lotteryRepository = $lotteryRepository;
        $this->prizeRepository = $prizeRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $count = (int)($this->argument('count') ?? 10);

        $user = User::find($userId);

        if($user) {
            $lottery = $this->lotteryRepository->findActive();
            $prizes = $this->prizeRepository->findNotSendMoneyPrizes($userId, $lottery->id);

            if(count($prizes) > 0) {
                $this->sendMoneyPrizes($prizes, $count);
            }
        }
    }

    private function sendMoneyPrizes($prizes, $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $prizes[$i]->update([
                'sent_at' => Carbon::now()
            ]);
        }
    }
}
