<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IrrigationWaterType;

class InitIrrigationWaterTypesCommand extends Command
{
    protected $signature = 'init:iwtypes';
    protected $description = 'Create initial irrigation water system types for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $types = [
            'Culinary',
            'Secondary'
        ];

        foreach($types as $type){
            IrrigationWaterType::create(['name' => $type]);
        }
    }
}
