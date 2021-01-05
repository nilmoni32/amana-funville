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
        Commands\DailyIngredient::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   //for ingredient scheduler
        $schedule->command('daily:ingredientUpdate')->dailyAt('0:00');
        //for database backup scheduler
        $schedule->command('backup:clean')->dailyAt('0:00');
        $schedule->command('backup:run --only-db')->dailyAt('13:00');
        $schedule->command('backup:run --only-db')->dailyAt('16:00');
        $schedule->command('backup:run --only-db')->dailyAt('19:00');
        $schedule->command('backup:run --only-db')->dailyAt('22:00');         
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
