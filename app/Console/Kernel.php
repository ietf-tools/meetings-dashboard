<?php

namespace App\Console;

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
        //
        //\App\Console\Commands\QueryParticipants::class,
        //\App\Console\Commands\UpdateParticipants::class,
        //\App\Console\Commands\QuerySessions::class,
       //\App\Console\Commands\UpdateSessions::class,
        //\App\Console\Commands\ParticipantCount::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('QueryParticipants:cron')->everyTwoMinutes()->withoutOverlapping();
        $schedule->command('QuerySessions:cron')->everyThreeHours()->withoutOverlapping();
        $schedule->command('UpdateParticipants:cron')->everyThreeMinutes()->withoutOverlapping();
        $schedule->command('UpdateSessions:cron')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('ParticipantCount:cron')->everyThreeMinutes();
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
