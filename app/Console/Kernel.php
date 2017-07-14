<?php

namespace App\Console;

use App\Console\Commands\Server\Rcon;
use App\Console\Commands\User\Block;
use App\Console\Commands\User\Create;
use App\Console\Commands\User\Remove;
use App\Console\Commands\User\Activate;
use App\Console\Commands\Payment\Complete;
use App\Console\Commands\User\Unblock;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
