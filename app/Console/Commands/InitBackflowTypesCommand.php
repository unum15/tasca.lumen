<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BackflowType;
use App\BackflowTypeValve;
use App\BackflowValvePart;
use App\BackflowManufacturer;
use App\BackflowModel;
use App\BackflowWaterSystem;
use App\BackflowSize;


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
                        'Diaphragm'
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
            ],
            'DC' => [
                [
                    'name' => 'Check Valve #1',
                    'test_name' => 'Held at',
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
                    'name' => 'Check Valve #2',
                    'test_name' => 'Held at',
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
            ],
            'PVB' => [
                [
                    'name' => 'Air Inlet',
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
                [
                    'name' => 'Check Valve',
                    'test_name' => 'Held at:',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked',
                    'parts' => [
                        'Air Inlet Disc',
                        'Air Inlet Spring',
                        'Check Disc',
                        'Check Spring'
                    ]
                ]
            ],
            'SVB' => [
                [
                    'name' => 'Air Inlet',
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
                [
                    'name' => 'Check Valve',
                    'test_name' => 'Held at:',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked',
                    'parts' => [
                        'Air Inlet Disc',
                        'Air Inlet Spring',
                        'Check Disc',
                        'Check Spring'
                    ]
                ]
            ],
            'DCDA' => [
                [
                    'name' => 'Check Valve #1',
                    'test_name' => 'Held at',
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
                    'name' => 'Check Valve #2',
                    'test_name' => 'Held at',
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
            ],
            'RPDA' => [
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
                        'Diaphragm'
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
            ],
            'AVB' => [
                [
                    'name' => 'Air Inlet',
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
                [
                    'name' => 'Check Valve',
                    'test_name' => 'Held at:',
                    'success_label' => 'Closed tight',
                    'fail_label' => 'Leaked',
                    'parts' => [
                        'Air Inlet Disc',
                        'Air Inlet Spring',
                        'Check Disc',
                        'Check Spring'
                    ]
                ]
            ]
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
			"ARI",
			"Ames",
			"Apollo",
			"Backflow Direct",
			"Colt",
			"Conbraco",
			"Febco",
			"Flomatic",
			"Watts",
			"Weathermatic",
			"Wilkins"
        ];
        $sort = 1;
        foreach($names as $name){
            BackflowManufacturer::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
			"1/2",
			"3/4",
            "3/8",
            "1",
			"1-1/4",
			"1-1/2",
			"2",
			"2-1/2",
			"3",
			"4",
			"6",
            "8",
            "10",
            "12"
        ];
        
        $sort = 1;
        foreach($names as $name){
            BackflowSize::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
        "4SG-100"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["3"],
              "type" => "DC"
            ],
          "LF007M1QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1","2"],
              "type" => "DC"
            ],
          "RTP4A"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1-1/2"],
              "type" => "RP"
            ],
          "LF007M10T"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2"],
              "type" => "DC"
            ],
          "950"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["2","1","3","4"],
              "type" => "DC"
            ],
          "009M3"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4","1/2","43528"],
              "type" => "RP"
            ],
          "460"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1/2"],
              "type" => "SVB"
            ],
          "40-105-T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "40-107-A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "375XLB"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1-1/2","2"],
              "type" => "RP"
            ],
          "909QTRPL"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "DC4A"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["6","1"],
              "type" => "DC"
            ],
          "007M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "DC"
            ],
          "009-M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "COLT400"=>
            [
              "manufacturer" => "Ames",
              "size" => ["2-1/2","2.5"],
              "type" => "RP"
            ],
          "SS009M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "975XL2"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1","3/4","1-1/2","2"],
              "type" => "RP"
            ],
          "40108A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "RP4A"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1","2"],
              "type" => "RP"
            ],
          "LF800M4QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2","3/4"],
              "type" => "PVB"
            ],
          "975XL"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["2","","1-1/2","1.5","1-1/4","1","3/4"],
              "type" => "RP"
            ],
          "LF008PCQT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["43467","43532","3/8","1/2"],
              "type" => "PVB"
            ],
          "007M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1.5","1-1/2","37257"],
              "type" => "DC"
            ],
          "775QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1"],
              "type" => "DC"
            ],
          "007M1"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2","1"],
              "type" => "DC"
            ],
          "805Y"=>
            [
              "manufacturer" => "Febco",
              "size" => ["3/4","1","2","1-1/2"],
              "type" => "DC"
            ],
          "40205T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "RP"
            ],
          "870"=>
            [
              "manufacturer" => "Febco",
              "size" => ["4"],
              "type" => "DC"
            ],
          "RP4040-2-0002"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["3"],
              "type" => "RP"
            ],
          "DCVE"=>
            [
              "manufacturer" => "Weathermatic",
              "size" => ["1"],
              "type" => "DC"
            ],
          "008PCQT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2","3/8","43532"],
              "type" => "SVB"
            ],
          "909QTM1"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/2"],
              "type" => "RP"
            ],
          "LF007QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2"],
              "type" => "DC"
            ],
          "DCLF4A"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1","2.5"],
              "type" => "DC"
            ],
          "765"=>
            [
              "manufacturer" => "Febco",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "850V"=>
            [
              "manufacturer" => "Febco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "909MAQT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2"],
              "type" => "RP"
            ],
          "DCV"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "850"=>
            [
              "manufacturer" => "Febco",
              "size" => ["1-1/2","1"],
              "type" => "DC"
            ],
          "ASSE1015"=>
            [
              "manufacturer" => "Flomatic",
              "size" => ["1"],
              "type" => "DC"
            ],
          "40-106-A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "009-M2"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/2","3/4"],
              "type" => "RP"
            ],
          "40-108-A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "009M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "720"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "720-A"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "975XLT"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "DC"
            ],
          "975"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["3","1","2"],
              "type" => "RP"
            ],
          "40-107-T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "LF007M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/2","1"],
              "type" => "DC"
            ],
          "975XLSEU"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1-1/4","2"],
              "type" => "RP"
            ],
          "880V"=>
            [
              "manufacturer" => "Febco",
              "size" => ["4"],
              "type" => "RP"
            ],
          "007"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3","2-1/2","2"],
              "type" => "DC"
            ],
          "LF009M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2","1-1/2","1"],
              "type" => "RP"
            ],
          "909"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4","1","1.5","2"],
              "type" => "RP"
            ],
          "950XL"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["25","1","2","1-1/2"],
              "type" => "DC"
            ],
          "FLF009M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "10002"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["3"],
              "type" => "DC"
            ],
          "957"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3"],
              "type" => "RP"
            ],
          "4010899T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "SS009-QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2"],
              "type" => "RP"
            ],
          "40107A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "RP40205T2"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1"],
              "type" => "RP"
            ],
          "PVB"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "PVB"
            ],
          "LF009M3QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "500"=>
            [
              "manufacturer" => "ARI",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "COLT-200"=>
            [
              "manufacturer" => "Ames",
              "size" => ["3"],
              "type" => "DC"
            ],
          "40-204-A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "40-205-T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "RP"
            ],
          "800M4QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2","3/4"],
              "type" => "PVB"
            ],
          "401**A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "FL009QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2"],
              "type" => "RP"
            ],
          "077M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/4"],
              "type" => "DC"
            ],
          "757"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3"],
              "type" => "DC"
            ],
          "4010599T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "375"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["4","3","1","1-1/2","2"],
              "type" => "RP"
            ],
          "40-104-T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "375XL"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1","1-1/2"],
              "type" => "RP"
            ],
          "40-204-T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "720A"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "40-105-A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "4010702"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "LF0092QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2"],
              "type" => "RP"
            ],
          "FL007M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "RPA4-200"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1"],
              "type" => "RP"
            ],
          "40-107-A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "DERINGER"=>
            [
              "manufacturer" => "Backflow Direct",
              "size" => ["3"],
              "type" => "DC"
            ],
          "RP40"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1","2"],
              "type" => "RP"
            ],
          "DC-200"=>
            [
              "manufacturer" => "Colt",
              "size" => ["2-1/2"],
              "type" => "DC"
            ],
          "909M1QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2","1-1/4"],
              "type" => "RP"
            ],
          "825YA"=>
            [
              "manufacturer" => "Febco",
              "size" => ["2","1"],
              "type" => "RP"
            ],
          "FL007M1QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2"],
              "type" => "DC"
            ],
          "40-105-99T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "800M4"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "825Y"=>
            [
              "manufacturer" => "Febco",
              "size" => ["1","1-1/2","2"],
              "type" => "RP"
            ],
          "4020599T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "RP"
            ],
          "40105A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2","1"],
              "type" => "DC"
            ],
          "909QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4"],
              "type" => "RP"
            ],
          "40-105-A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "009"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3","1-1/4","1-1/2","1/2"],
              "type" => "RP"
            ],
          "775"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3"],
              "type" => "DC"
            ],
          "860"=>
            [
              "manufacturer" => "Febco",
              "size" => ["3","1"],
              "type" => "RP"
            ],
          "975XLU"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "RP"
            ],
          "40-103-42T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "007M1QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["2","1"],
              "type" => "DC"
            ],
          "805YD"=>
            [
              "manufacturer" => "Febco",
              "size" => ["3"],
              "type" => "DC"
            ],
          "COLT200"=>
            [
              "manufacturer" => "Ames",
              "size" => ["6","2-1/2","3","4"],
              "type" => "DC"
            ],
          "950XLT"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["2","1-/14","1-1/2","1"],
              "type" => "DC"
            ],
          "009QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["43467","3/4","1/2"],
              "type" => "RP"
            ],
          "775Q"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1"],
              "type" => "DC"
            ],
          "40-207-A2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "RP"
            ],
          "009M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/2","2","1.25"],
              "type" => "RP"
            ],
          "709"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3"],
              "type" => "DC"
            ],
          "40105T2"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "LF009QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2","43467"],
              "type" => "RP"
            ],
          "420"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["1"],
              "type" => "PVB"
            ],
          "350A"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["6"],
              "type" => "DC"
            ],
          "XXXX99T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "009-M2QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["3/4","1","2","1.5","1-1/2"],
              "type" => "RP"
            ],
          "007QT"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1/2"],
              "type" => "DC"
            ],
          "200"=>
            [
              "manufacturer" => "Colt",
              "size" => ["6","3"],
              "type" => "DC"
            ],
          "4010799T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1-1/2"],
              "type" => "DC"
            ],
          "870V"=>
            [
              "manufacturer" => "Febco",
              "size" => ["3"],
              "type" => "DC"
            ],
          "350AST"=>
            [
              "manufacturer" => "Wilkins",
              "size" => ["4","3"],
              "type" => "DC"
            ],
          "40-104-A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["1"],
              "type" => "DC"
            ],
          "40-108-A2T"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "DC"
            ],
          "007M2"=>
            [
              "manufacturer" => "Watts",
              "size" => ["1-1/4","1-1/2"],
              "type" => "DC"
            ],
          "4050802"=>
            [
              "manufacturer" => "Conbraco",
              "size" => ["2"],
              "type" => "PVB"
            ],
          "880"=>
            [
              "manufacturer" => "Febco",
              "size" => ["4"],
              "type" => "RP"
            ],
          "RPLF4A"=>
            [
              "manufacturer" => "Apollo",
              "size" => ["1-1/2","1","3/4"],
              "type" => "RP"
            ],
        ];
        $sort = 1;
        foreach($names as $name => $model){
            $manufacturer = BackflowManufacturer::where('name',$model['manufacturer'])->first();
            if(!$manufacturer){
                print $model['manufacturer'];
                exit;
            }
            $type = BackflowType::where('name',$model['type'])->first();
            $model_obj = BackflowModel::create([
                'name' => $name,
                'backflow_manufacturer_id' => $manufacturer->id,
                'backflow_type_id' => $type->id,
                'sort_order' => $sort++
            ]);
            foreach($model['size'] as $size_name){
                $size = BackflowSize::where('name',$size_name)->first();
                if($size){
                    $model_obj->backflow_sizes()->attach([$size->id]);
                }
                
            }
        }


        $names = [
            "Bona Vista",
			"Bountiful City",
			"Centerville City",
			"Central Utah",
			"Clearfield City",
			"Clinton City",
			"Cottonwood Heights City",
			"Draper City",
			"Farmington City",
			"Garden City",
			"Granger-Hunter",
			"Jordan Valley",
			"Kaysville City",
			"Kearns City",
			"Layton City",
			"Logan City",
			"MTRegional",
			"Magna City",
			"Midvale City",
			"Murray City",
			"North Salt Lake City",
			"Ogden City",
			"Pleansant View City",
			"Riverdale City",
			"Riverton City",
			"Roy City",
			"Salt Lake City",
			"Sandy City",
			"Saratoga Springs City",
			"South Jordan City",
			"South Ogden City",
			"South Salt Lake City",
			"South Weber City",
			"Sugar House",
			"Sunset City",
			"Syracuse City",
			"Taylorsville-Bennion Improvement",
			"Water Pro",
			"West Bountiful City",
			"West Jordan City",
			"West Point City",
			"Woodscross City"
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
