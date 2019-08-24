<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate default data for Tasca.';

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
        $this->call('init:roles');
        $this->call('init:types');
        $this->call('init:settings');
        $this->call('init:admin');
    }
}
