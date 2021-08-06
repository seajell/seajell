<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {password} {fullname=admin} {email=admin@site.local}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'eKV: Migrate the databases and create a new admin user with the username: admin.';

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
        Artisan::call('migrate'); // Migrate the database
        $this->info('Database migrated!');
        User::upsert([
            ['username' => 'admin', 'fullname' => $this->argument('fullname'), 'fullname' => $this->argument('fullname'), 'email' => $this->argument('email'), 'password' => Hash::make($this->argument('password')), 'role' => 'superadmin']
        ], ['username'], ['fullname', 'fullname', 'email', 'password', 'role']);
        Artisan::call('storage:link'); // Create symbolic links
        $this->info('A user with the admin user was successfully created or updated!');
        $this->info('System was successfully installed!');
    }
}
