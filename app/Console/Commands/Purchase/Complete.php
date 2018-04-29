<?php
declare(strict_types = 1);

namespace App\Console\Commands\Purchase;

use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Exceptions\Purchase\DoesNotExistsException;
use App\Handlers\Console\Purchase\CompleteHandler;
use Illuminate\Console\Command;

class Complete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:complete {purchase_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to complete a purchase with the specified identifier.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param CompleteHandler $handler
     *
     * @return int
     */
    public function handle(CompleteHandler $handler): int
    {
        $id = (int)$this->argument('purchase_id');
        try {
            $handler->handle($id);
        } catch (DoesNotExistsException $e) {
            $this->error(__('commands.purchase.complete.not_found'));

            return 1;
        } catch (AlreadyCompletedException $e) {
            $this->error(__('commands.purchase.complete.already_completed'));

            return 2;
        }

        $this->info(__('commands.purchase.complete.success'));

        return 0;
    }
}
