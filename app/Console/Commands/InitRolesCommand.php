<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;

class InitRolesCommand extends Command
{
    
    protected $signature = 'init:roles';
    protected $description = 'Create initial roles for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        $admin = Role::create([
            'name'         => 'admin',
            'display_name' => 'Tasca Administrator',
            'description'  => 'User is allowed to manage and edit everything',
        ]);

        $laborer = Role::create([
            'name' => 'laborer',
            'display_name' => 'Laborer',
            'description' => 'Can view own assignments and clock in',
        ]);

        $scheduler = Role::create([
            'name' => 'scheduler',
            'display_name' => 'Scheduler',
            'description' => 'Can schedule and view all jobs and clients',
        ]);

        $clientAdmin = Role::create([
            'name' => 'client-admin',
            'display_name' => 'Client Administrator',
            'description' => 'User is allowed to manage and edit everything for specified client.',
        ]);

        $clientEmployee = Role::create([
            'name' => 'client-employee',
            'display_name' => 'Client Employee',
            'description' => 'User is an employee of specified client.',
        ]);

        $viewClients = Permission::create([
            'name' => 'view-clients',
            'display_name' => 'View Clients',
            'description' => 'View clients and related data.',
        ]);
        
        $editClients = Permission::create([
            'name' => 'edit-clients',
            'display_name' => 'Edit Clients',
            'description' => 'Edit and create clients and existing data',
        ]);
        
        $editSettings = Permission::create([
            'name' => 'edit-settings',
            'display_name' => 'Edit Settings',
            'description' => 'Edit settings',
        ]);
        
        $clockIn = Permission::create([
            'name' => 'clock-in',
            'display_name' => 'clock-in',
            'description' => 'clock-in',
        ]);
        
        $editTimeCards = Permission::create([
            'name' => 'edit-time-cards',
            'display_name' => 'Edit Time Cards',
            'description' => 'Edit Time Cards',
        ]);
        
        $viewAssignments = Permission::create([
            'name' => 'view-assignments',
            'display_name' => 'View Assignments',
            'description' => 'View assignments and tasks.',
        ]);
        
        $viewSchedule = Permission::create([
            'name' => 'view-schedule',
            'display_name' => 'View Schedule',
            'description' => 'View schedule and tasks.',
        ]);
        
        
        $viewClient = Permission::create([
            'name' => 'view-client',
            'display_name' => 'View Client',
            'description' => 'View associated client and related data.',
        ]);
        
        $editClient = Permission::create([
            'name' => 'edit-client',
            'display_name' => 'Edit Client',
            'description' => 'Edit associated client and existing data',
        ]);
        
        $viewProjects = Permission::create([
            'name' => 'view-projects',
            'display_name' => 'View Projects',
            'description' => 'View projects and related data.',
        ]);
        
        $editProjects = Permission::create([
            'name' => 'edit-projects',
            'display_name' => 'Edit Projects',
            'description' => 'Edit and create projects, orders, and tasks for associated clients',
        ]);
        
        $employeeLogin = Permission::create([
            'name' => 'login-employee',
            'display_name' => 'Employee Login',
            'description' => 'Login to the employee interface',
        ]);
        
        $clientLogin = Permission::create([
            'name' => 'login-client',
            'display_name' => 'Client Login',
            'description' => 'Login to the client interface',
        ]);

        $admin->permissions()->sync([$employeeLogin->id, $viewClients->id, $editClients->id, $editSettings->id, $clockIn->id, $editTimeCards->id, $viewSchedule->id, $viewAssignments->id]);
        $laborer->permissions()->sync([$employeeLogin->id, $viewAssignments->id, $clockIn->id]);
        $scheduler->permissions()->sync([$employeeLogin->id, $viewClients->id, $clockIn->id, $viewSchedule->id]);
        $clientAdmin->permissions()->sync([$clientLogin->id, $viewClient->id, $editClient->id, $viewProjects->id, $editProjects->id]);
        $clientEmployee->permissions()->sync([$clientLogin->id, $viewClient->id, $viewProjects->id, $editProjects->id]);
    }
}
