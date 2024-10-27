<?php

namespace App\Console\Commands;

use App\IrrigationControllerLocation;
use App\IrrigationWaterType;
use Illuminate\Console\Command;

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
            'Secondary',
            'Dual',
            'Well',
        ];

        foreach ($types as $type) {
            IrrigationWaterType::create(['name' => $type]);
        }

        $types = [
            'Inside',
            'Outside',
        ];

        foreach ($types as $type) {
            IrrigationControllerLocation::create(['name' => $type]);
        }
    }
}
