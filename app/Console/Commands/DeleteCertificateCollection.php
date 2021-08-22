<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateCollectionDeletionSchedule;

class DeleteCertificateCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteCertificateCollection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes the Certificate Collection records from database and the directories in storage if it passed the deletion date (delete_after).';

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
     * @return int
     */
    public function handle()
    {
        $allDeletionScheduled = CertificateCollectionDeletionSchedule::get();
        foreach ($allDeletionScheduled as $deletion) {
            // If current data time passed the delete after data, delete the folder and the schedule from database
            if(Carbon::now()->toDateTimeString() > $deletion->delete_after){
                $folderName = $deletion->folder_name;
                Storage::disk('local')->deleteDirectory('/certificate/' . $folderName);
                CertificateCollectionDeletionSchedule::where('id', $deletion->id)->delete();
            }
        }
    }
}
