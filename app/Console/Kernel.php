<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\DeleteCertificateCollection;
use App\Models\CertificateCollectionDeletionSchedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DeleteCertificateCollection::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Task to delete certificate collection folder every 3 hours.
        $schedule->command('deleteCertificateCollection')->everyThreeHours();
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
