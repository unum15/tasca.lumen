<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BackflowType;
use App\BackflowTypeValve;
use App\BackflowValvePart;
use App\BackflowManufacturer;
use App\BackflowModel;
use App\BackflowUse;
use App\BackflowWaterSystem;


class InitBackflowTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:bftypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial backflow related types for Tasca.';

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
            'RP' => [
                [
                    'name' => 'Check Valve #1',
                    'test_name' => 'PSI Across',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked',
                    'parts' => [
                        'Disc',
                        'Spring',
                        'Guide',
                        'Pin Feather',
                        'Hinge Pin',
                        'Seat',
                        'Diaphragm',
                        'Other'
                    ]
                ],
                [
                    'name' => 'Check Valve #2',
                    'test_name' => 'PSI Across',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked',
                    'parts' => [
                        'Disc',
                        'Spring',
                        'Guide',
                        'Pin Feather',
                        'Hinge Pin',
                        'Seat',
                        'Diaphragm'
                    ]
                ],
                [
                    'name' => 'Differential Pressure Relief Valve',
                    'test_name' => 'Opened at',
                    'success_label' => 'Opened Under 2#',
                    'fail_label' => 'Did not open',
                    'parts' => [
                        'Disc',
                        'Spring',
                        'Seat(s)',
                        'Diaphragm',
                        'O-ring(s)',
                        'Module'
                    ]
                ],
                [
                    'name' => 'Pressure Vacuum Breaker',
                    'test_name' => 'Opened at',
                    'success_label' => 'Opened Under 1#',
                    'fail_label' => 'Did not open',
                    'parts' => [
                        'Air Inlet Disc',
                        'Air Inlet Spring',
                        'Check Disc',
                        'Check Spring'
                    ]
                ],
            ],
            'DC' => [
                [
                    'name' => 'Check Valve #1',
                    'test_name' => 'Held at',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked'
                ],
                [
                    'name' => 'Check Valve #2',
                    'test_name' => 'Held at',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked'
                ],
                [
                    'name' => 'Pressure Vacuum Breaker',
                    'test_name' => 'Check Valve',
                    'success_label' => 'Opened Under 1#',
                    'fail_label' => 'Did not open'
                ],
            ],
            'PVB' => [],
            'SVB' => [],
            'DCDA' => [],
            'RPDA' => [],
            'AVB' => []
        ];
        
        
        
        $sort = 1;
        foreach($names as $name => $valves){
            $type = BackflowType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            
            foreach($valves as $valvea){
                $valvea['backflow_type_id'] = $type->id;
                $valve = BackflowTypeValve::create($valvea);
                if(isset($valvea['parts'])){
                    foreach($valvea['parts'] as $part){
                        BackflowValvePart::create(['backflow_type_valve_id' => $valve->id,'name' => $part]);
                    }
                }
            }
        }

        $names = [
            
        ];
        
        $sort = 1;
        foreach($names as $name){
            BackflowManufacturer::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            
        ];
        
        $sort = 1;
        foreach($names as $name){
            BackflowModel::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            
        ];
        
        $sort = 1;
        foreach($names as $name){
            BackflowUse::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            
        ];
        
        $sort = 1;
        foreach($names as $name){
            BackflowWaterSystem::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
    }
}
