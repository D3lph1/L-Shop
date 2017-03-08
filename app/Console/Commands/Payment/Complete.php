<?php

namespace App\Console\Commands\Payment;

use App\Services\QueryManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class Complete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:complete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete payment and give products or money to user';

    /**
     * @var QueryManager
     */
    protected $qm;

    /**
     * Create a new command instance.
     *
     * @param QueryManager $qm
     */
    public function __construct(QueryManager $qm)
    {
        $this->qm = $qm;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = (int)$this->argument('id');
        $distributor = \App::make('distributor');
        $payment = $this->qm->payment($id);

        if (!$payment) {
            $this->error('Payment not found');

            return 1;
        }

        if ($payment->completed) {
            $this->error('Payment already completed');

            return 2;
        }

        if (!$payment->products) {
            refill_user_balance((int)$payment->cost, $payment->user_id);
            $this->qm->completePayment($payment->id, 'Завершен администратором');
            $this->info('Payment successfully completed and user balance updated');

            return 0;
        }

        $distributor->give($payment);
        $this->info('Payment successfully completed and products given');

        return 0;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return [
            ['id', InputArgument::REQUIRED, 'Payment id']
        ];
    }
}
