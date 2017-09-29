<?php
declare(strict_types = 1);

namespace App\Console\Commands\Payment;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\TransactionScripts\Payments;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Complete
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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
     * @var Payments
     */
    protected $script;

    /**
     * Create a new command instance.
     *
     * @param Payments $script
     */
    public function __construct(Payments $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $this->script->complete((int)$this->argument('id'));
        } catch (NotFoundException $e) {
            $this->error('Payment not found');

            return 1;
        } catch (AlreadyCompletedException $e) {
            $this->error('Payment already completed');

            return 2;
        }

        $this->info('Payment successfully completed and products given');

        return 0;
    }

    public function getArguments(): array
    {
        return [
            ['id', InputArgument::REQUIRED, 'Payment id']
        ];
    }
}
