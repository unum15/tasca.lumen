<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitAllCommand extends Command
{

    protected $signature = 'init:all';
    protected $description = 'Populate default data for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('init:roles');
        $this->call('init:types');
        $this->call('init:settings');
        $this->call('init:asset-types');
        $this->call('init:bftypes');
        $this->call('init:iwtypes');
        $this->call('init:overhead');
        $this->call('init:admin');
    }
}
