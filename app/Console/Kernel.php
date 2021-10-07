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
        Commands\DeleteCertificateCollection::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Task to delete certificate collection folder every 3 hours.
        $schedule->command('deleteCertificateCollection')->everyThreeHours();

        // Only run this when set to true the env variable SHARED_HOSTING_ENABLED=true, default: false.
        if (config('seajell.shared_hosting.enabled')) {
            $schedule->command('queue:restart')->everyFiveMinutes();
            $schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
