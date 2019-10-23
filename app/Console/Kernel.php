<?php

namespace App\Console;

use App\Console\Commands\UpdateICalFeed;
use App\Console\Commands\UpdateScans;
use App\Console\Commands\UpdateTickets;
use App\Console\Commands\UpdateUnionCloudEvents;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Horizon\Console\SnapshotCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(UpdateICalFeed::class)->everyFiveMinutes();
        $schedule->command(UpdateUnionCloudEvents::class)->everyFiveMinutes();
        $schedule->command(UpdateScans::class)->everyMinute();
        $schedule->command(UpdateTickets::class)->everyMinute();
        $schedule->command(SnapshotCommand::class)->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
