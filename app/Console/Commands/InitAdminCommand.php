<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Client;
use App\Contact;
use App\Setting;
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
            'contact_method_id' => ClientMethod::where('name', 'None')->first()->id,
            'login' => 'admin@example.com',
            'show_maximium_activity_level_id' => 5,
            'password' => password_hash("adminpass", PASSWORD_DEFAULT),
            'creator_id' => 1,
            'updater_id' => 1 
        ]);
        
        $adminCompany = Client::create([
            'name' => 'Admin Company',
            'client_type_id' => ClientType::where('name', 'Other')->first()->id,
            'contact_method_id' => ClientMethod::where('name', 'None')->first()->id,
            'billing_contact_id' => $adminUser->id,
            'activity_level_id' => 1,
            'login' => 'admin@example.com',
            'show_maximium_activity_level_id' => 5,
            'password' => password_hash("adminpass", PASSWORD_DEFAULT),
            'creator_id' => $adminUser->id,
            'updater_id' => $adminUser->id 
        ]);

        $adminCompany->clients()->sync([$adminUser->id]);

        Setting::create([
            'name' => 'operating_company_client_id',
            'value' => $adminCompany->id
        ]);
        $admin = Role::where('name', 'admin')->first();
        $adminUser->roles()->attach($admin);
    }
}
