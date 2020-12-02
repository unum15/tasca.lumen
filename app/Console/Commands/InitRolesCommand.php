<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Permission;
use App\Role;

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
        
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Tasca Administrator';
        $admin->description  = 'User is allowed to manage and edit everything';
        $admin->save();

        $laborer = new Role();
        $laborer->name         = 'laborer';
        $laborer->display_name = 'Laborer';
        $laborer->description  = 'Can view own assignments';
        $laborer->save();

        $scheduler = new Role();
        $scheduler->name         = 'scheduler';
        $scheduler->display_name = 'Scheduler';
        $scheduler->description  = 'Can schedule and view all jobs and clients';
        $scheduler->save();

        $clientAdmin = new Role();
        $clientAdmin->name         = 'client-admin';
        $clientAdmin->display_name = 'Client Administrator';
        $clientAdmin->description  = 'User is allowed to manage and edit everything for specified client.';
        $clientAdmin->save();

        $clientEmployee = new Role();
        $clientEmployee->name         = 'client-employee';
        $clientEmployee->display_name = 'Client Employee';
        $clientEmployee->description  = 'User is an employee of specified client.';
        $clientEmployee->save();

        $viewClients = new Permission();
        $viewClients->name = 'view-clients';
        $viewClients->display_name = 'View Clients';
        $viewClients->description = 'View clients and related data.';
        $viewClients->save();
        
        $editClients = new Permission();
        $editClients->name = 'edit-clients';
        $editClients->display_name = 'Edit Clients';
        $editClients->description = 'Edit and create clients and existing data';
        $editClients->save();
        
        $editSettings = new Permission();
        $editSettings->name = 'edit-settings';
        $editSettings->display_name = 'Edit Settings';
        $editSettings->description = 'Edit settings';
        $editSettings->save();
        
        $clockIn = new Permission();
        $clockIn->name = 'clock-in';
        $clockIn->display_name = 'clock-in';
        $clockIn->description = 'clock-in';
        $clockIn->save();
        
        $editTimeCards = new Permission();
        $editTimeCards->name = 'edit-time-cards';
        $editTimeCards->display_name = 'Edit Time Cards';
        $editTimeCards->description = 'Edit Time Cards';
        $editTimeCards->save();
        
        $viewSchedule = new Permission();
        $viewSchedule->name = 'view-schedule';
        $viewSchedule->display_name = 'View Schedule';
        $viewSchedule->description = 'View schedule and tasks.';
        $viewSchedule->save();
        
        
        $viewClient = new Permission();
        $viewClient->name = 'view-client';
        $viewClient->display_name = 'View Client';
        $viewClient->description = 'View associated client and related data.';
        $viewClient->save();
        
        $editClient = new Permission();
        $editClient->name = 'edit-client';
        $editClient->display_name = 'Edit Client';
        $editClient->description = 'Edit associated client and existing data';
        $editClient->save();
        
        $viewProjects = new Permission();
        $viewProjects->name = 'view-projects';
        $viewProjects->display_name = 'View Projects';
        $viewProjects->description = 'View projects and related data.';
        $viewProjects->save();
        
        $editProjects = new Permission();
        $editProjects->name = 'edit-projects';
        $editProjects->display_name = 'Edit Projects';
        $editProjects->description = 'Edit and create projects, orders, and tasks for associated clients';
        $editProjects->save();
        
        $employeeLogin = new Permission();
        $employeeLogin->name = 'login-employee';
        $employeeLogin->display_name = 'Employee Login';
        $employeeLogin->description = 'Login to the employee interface';
        $employeeLogin->save();
        
        $clientLogin = new Permission();
        $clientLogin->name = 'login-client';
        $clientLogin->display_name = 'Client Login';
        $clientLogin->description = 'Login to the client interface';
        $clientLogin->save();
        
        $admin->attachPermissions([$employeeLogin, $viewClients, $editClients, $editSettings, $clockIn, $editTimeCards, $viewSchedule]);
        $laborer->attachPermissions([$employeeLogin, $viewAssignments, $clockIn]);
        $scheduler->attachPermissions([$employeeLogin, $viewClients, $clockIn, $viewSchedule]);
        $clientAdmin->attachPermissions([$clientLogin, $viewClient, $editClient, $viewProjects, $editProjects]);
        $clientEmployee->attachPermissions([$clientLogin, $viewClient, $viewProjects, $editProjects]);
    }
}
