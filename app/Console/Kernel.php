<?php
declare(strict_types = 1);

namespace App\Console;

use App\Console\Commands\Payment\Complete;
use App\Console\Commands\Server\Rcon;
use App\Console\Commands\User\Activate;
use App\Console\Commands\User\Block;
use App\Console\Commands\User\Create;
use App\Console\Commands\User\Remove;
use App\Console\Commands\User\Unblock;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Create::class,
        Remove::class,
        Activate::class,
        Block::class,
        Unblock::class,
        Complete::class,
        Rcon::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands(): void
    {
        require base_path('routes/console.php');
    }
}
