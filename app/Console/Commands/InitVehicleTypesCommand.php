<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ServiceType;
use App\UsageType;
use App\VehicleType;



class InitVehicleTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:vtypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial vehicle related types for Tasca.';

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
        $names = [
                'Check',
                'Change',
                'Clean',
                'Replace'
        ];
        $sort = 1;
        foreach($names as $name){
            ServiceType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            'Miles',
            'Hours'
        ];
        $sort = 1;
        foreach($names as $name){
            UsageType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Auto",
            "Trailers",
            "Equipment"
        ];
        $sort = 1;
        foreach($names as $name){
            VehicleType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
    }
}
