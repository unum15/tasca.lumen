<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contact;

class InitAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial admin account for Tasca.';

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
     * @return mixed
     */
    public function handle()
    {
        $adminUser = Contact::create([
            'name' => 'Admin',
            'activity_level_id' => 1,
            'login' => 'admin@example.com',
            'show_maximium_activity_level_id' => 5,
            'password' => password_hash("adminpass", PASSWORD_DEFAULT),
            'creator_id' => 1,
            'updater_id' => 1 
        ]);
        
        $adminUser->attachRole($admin);
    }
}
