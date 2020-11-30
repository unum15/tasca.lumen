<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contact;
//use App\Role;

class InitAdminCommand extends Command
{
    protected $signature = 'init:admin';
    protected $description = 'Create initial admin account for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

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
//        $admin = Role::where('name', 'admin')->first();
//        $adminUser->attachRole($admin);
    }
}
