<?php

namespace App\Console\Commands\Payment;

use App\Repositories\PaymentRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Complete
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Console\Commands\Payment
 */
class Complete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:complete {id : Payment identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete payment and give products or money to user';

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * Create a new command instance.
     *
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
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
        $payment = $this->paymentRepository->find($id);

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
            $this->paymentRepository->complete($payment->id, 'Завершен администратором');
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
