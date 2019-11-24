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
			"ARI",
			"Ames",
			"Amess",
			"Ammes",
			"Apollo",
			"Appollo",
			"Backflow Direct",
			"Colt",
			"Conbraco",
			"Febco",
			"Flomatic",
			"Waters",
			"Watts",
			"Weather matic",
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
			"007",
			"007M1",
			"007M1 QT",
			"007M1QT",
			"007M2",
			"007M2 QT",
			"007M2QT",
			"007M3QT",
			"007QT",
			"008PCQT",
			"009",
			"009 M3",
			"009 M3 QT",
			"009 QT",
			"009-M2",
			"009-M2QT",
			"009-M3 QT",
			"009-M3QT",
			"009M2 QT",
			"009M2QT",
			"009M3",
			"009M3QT",
			"009QT",
			"009m3",
			"077M2QT",
			"200",
			"10002",
			"350A",
			"350AST",
			"375",
			"375 XL",
			"375XL",
			"375XLB",
			"40-103-42T",
			"40-104-A2T",
			"40-104-T2",
			"40-105-99T",
			"40-105-A2",
			"40-105-A2T",
			"40-105-T2",
			"40-106-A2T",
			"40-107-A2",
			"40-107-A2T",
			"40-107-T2",
			"40-108-A2",
			"40-108-A2T",
			"40-204-A2",
			"40-204-T2",
			"40-205-T2",
			"40-207-A2",
			"401**A2T",
			"4010599T",
			"4010599t",
			"40105A2T",
			"40105A2t",
			"40105T2",
			"4010702",
			"4010799T",
			"40107A2",
			"4010899T",
			"40108A2T",
			"4020599T",
			"40205T2",
			"420",
			"460",
			"4SG-100",
			"500",
			"709",
			"720",
			"720 A",
			"720-A",
			"757",
			"765 ",
			"775",
			"775Q",
			"775QT",
			"800M4",
			"800M4QT",
			"805Y",
			"805YD",
			"825Y",
			"825YA",
			"850",
			"850V",
			"860",
			"870",
			"870V",
			"880",
			"880V",
			"909",
			"909 M1 QT",
			"909M1QT",
			"909MAQT",
			"909QT",
			"909QTM1",
			"909QTRPL",
			"950",
			"950XL",
			"950XLT",
			"957",
			"975",
			"4050802",
			"975 XL",
			"975XL",
			"975XL2",
			"975XLSEU",
			"975XLT",
			"975XLU",
			"ASSE1015",
			"Colt 200",
			"Colt 400",
			"DC-200",
			"DC4A",
			"DCLF4A",
			"DCV",
			"DCVE",
			"Deringer",
			"FL007M1QT",
			"FL007M2QT",
			"FL009QT",
			"FLF009M3QT",
			"LF 007M10T",
			"LF007M1QT",
			"LF007M2QT ",
			"LF007QT",
			"LF008PCQT",
			"LF0092QT",
			"LF009M2QT",
			"LF009M3QT",
			"LF009QT",
			"LF009qt",
			"LF800M4QT",
			"PVB",
			"RP40",
			"RP40 40-2-0002",
			"RP40205T2",
			"RP4A",
			"RPA4-200",
			"RPLF4A",
			"RTP4A",
			"SS009-QT",
			"SS009M3QT",
			"xxxx99t"
        ];
        $sort = 1;
        foreach($names as $name){
            BackflowModel::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
			"Bakery Oven",
			"Bakery Puffer",
			"Battery Station",
			"Boiler",
			"Boiler Feed",
			"Building Main",
			"Car Wash",
			"Combo Ovens",
			"Combo Oven Bottom",
			"Combo Oven Top",
			"Dual Irrigation System",
			"Fill ponds and irrigations system",
			"Filtration",
			"Fire Riser",
			"Fire Suppression System",
			"Fountain water supply",
			"Garden Center",
			"Green House",
			"Hose End Sprayer",
			"Ice Machine",
			"Irrigation system",
			"Main Water Supply",
			"Mop Sink",
			"Pan Washer",
			"Pond Fill",
			"Pool & Pool house",
			"Portable Washer",
			"RO System",
			"Riser",
			"Salad Bar",
			"Serving Tables",
			"Shop Water",
			"Sink",
			"Sink Cold",
			"Sink Hot",
			"Soap Dsipener",
			"Soap Machine",
			"Soda Pop",
			"Soda Fountain",
			"Sprayer",
			"Sprinklers",
			"Steam Ovens",
			"Steam Table",
			"Steamer",
			"Suction Machine",
			"Wash Basin",
			"Wash Bay",
			"Washdow Equipment",
			"Washdown",
			"Water Softener",
			"Water Supply Bypass",
			"Waterfall fill"
        ];

        $sort = 1;
        foreach($names as $name){
            BackflowUse::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Bona Vista",
			"Bountiful City",
			"Centerville City",
			"Central Utah",
			"Clearfield City",
			"Clinton City",
			"Cottonwood Heigths",
			"Draper City",
			"Farmington",
			"Garden City",
			"Granger-Hunter",
			"Jordan Valley ",
			"Kaysville City",
			"Kearns",
			"Layton City",
			"Logan",
			"MTRegional",
			"Magna",
			"Midvale City",
			"Murray",
			"North Salt Lake",
			"Ogden City",
			"Pleansant View",
			"Riverdale City",
			"Riverton City",
			"Roy",
			"Salt Lake City",
			"Sandy City",
			"Saratoga Springs",
			"South Jordan",
			"South Ogden",
			"South Salt Lake",
			"South Weber",
			"Sugar house",
			"Sunset City",
			"Syracuse City",
			"Taylorsville-Bennion Improvement",
			"Water Pro",
			"West Bountiful",
			"West Jordan",
			"West Point",
			"Woodscross"
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
