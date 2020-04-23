<?php

use Illuminate\Database\Seeder;
use App\BackflowAssembly;
use App\BackflowType;
use App\BackflowWaterSystem;
use App\BackflowSize;
use App\BackflowManufacturer;
use App\BackflowModel;
use App\BackflowTestReport;
use App\BackflowTest;
use App\BackflowValvePart;
use App\BackflowRepair;
use App\BackflowCleaning;
use App\Contact;
use App\Project;
use App\Property;


class BackflowAssemblyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('backflow_assemblies')->delete();
        $faker = Faker\Factory::create();
        $properties = Property::all();
        $backflow_types = BackflowType::pluck('id')->toArray();
        $backflow_water_systems = BackflowWaterSystem::pluck('id')->toArray();
        $backflow_sizes = BackflowSize::pluck('id')->toArray();
        $backflow_manufacturers = BackflowManufacturer::pluck('id')->toArray();
        $backflow_models = BackflowModel::pluck('id')->toArray();

        $uses = [
			"Bakery Oven",
			"Bakery Puffer",
			"Battery Station",
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
			"Irrigation System",
			"Main Water Supply",
			"Mop Sink",
			"Pan Washer",
			"Pond Fill",
			"Pool & Pool House",
			"Portable Washer",
			"RO System",
			"Riser",
			"Salad Bar",
			"Serving Tables",
			"Shop Water",
			"Sink",
			"Sink Cold",
			"Sink Hot",
			"Soap Dispener",
			"Soda Fountain",
			"Sprayer",
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

        $placements = [
            "15' N Of 8600 S 2' W Drive Traingle Area Geen Box",
			"2nd Floor Steam Generator Room",
			"2nd Floor Suction Machine Room",
			"3rd Floor Boiler Room",
			"8' W Of Hyd On 1300 E 8' S Of Drive Green Box",
			"Above Cooking Pots",
			"Above Mop Sink",
			"Above Restrooms",
			"Above Walk In Cooler",
			"Along South Fence Line By Freeway",
			"Assisted Living Building Mechanical Room",
			"Back Corner Of Storage Room",
			"Back Docks",
			"Back Empty Unit Between Bbb And Dress Barn",
			"Back Hallway",
			"Back Of Building",
			"Back Of Kitchen",
			"Back Of Store",
			"Back Of Store By Docks",
			"Back Restroom Behind Door",
			"Back Room",
			"Back Room In Ceiling",
			"Back Stock Room",
			"Back Stock Room Above Door",
			"Back Storage Room",
			"Back Yard North East Corner Of House",
			"Backery Dept. Backfoom Next To Triple Sink",
			"Backroom South Wall",
			"Backroom West Wall",
			"Bakery",
			"Bakery Above Mop Sink",
			"Bakery Above Pan Washer",
			"Bakery Cooler Soap",
			"Bakery Dept",
			"Bakery In Back Under Sink",
			"Basball Field",
			"Basement",
			"Basement Mechanical Room",
			"Basement Ne In Basement",
			"Basement North Wall",
			"Basement South East Corner",
			"Basment Boiler Room",
			"Behind Building",
			"Behind Building In Fire Riser Room",
			"Behind Building In Valve Box",
			"Behind Deli Combi Ovens - Back",
			"Behind Deli Combi Ovens - Front",
			"Behind Deli Combi Ovens - Left",
			"Behind Deli Combi Ovens - Right",
			"Behind Fence On North Side",
			"Behind Fence On South Side",
			"Behind Fence On West Side",
			"Behind House",
			"Behind House By Ac",
			"Behind Main Building Along Wall In The Center",
			"Behind The North West Corner Of House",
			"Below Rock Wall By Sidewalk",
			"Between The House The  Walk To The Front Door In Valve Box",
			"Bistro Above Mop Right Sink",
			"Boiler Room",
			"Boiler Room Above Boiler",
			"Boiler Room In North Hall",
			"Boiler Room In South Hall",
			"Boiler Room On Roof",
			"Breakroom",
			"Breakroom Closet South Building",
			"Building B",
			"Building C",
			"Building D",
			"Bulding A",
			"Bulk Foods",
			"Butcher Front",
			"Butcher In Cooler",
			"Butcher Next To Ice Maker",
			"By Driveway Circle",
			"By Dumpster",
			"By Front Door",
			"By Front Door Under Stone",
			"By Front Porch",
			"By Meter",
			"By Side Walk In Valve Box",
			"By Side Walk In Valve Box In Front Of Building",
			"By South West Garage Door",
			"By The Walkway Front Door",
			"By Unit #D16 Next To Water Meter On North Property Line",
			"By Water Meter Infront Of Building",
			"Center Of Buildig",
			"Closet In Computer Room",
			"Closet In Garden Center",
			"Common North Side Of Oakbrush Drive",
			"Computer Room Basement",
			"Cooler Washdown",
			"Court Yard",
			"Deli",
			"Deli Above Mop Left Sink",
			"Deli Above Mop Right Sink",
			"Deli Above Mop Sink",
			"Deli Above Pan Washer",
			"Deli Back Next To Deli Cooler High On The Wall",
			"Deli Back Under Dish Rinsing Sink",
			"Deli Below Sink",
			"Deli Dept",
			"Deli Dept. By Hand Sink & Triple Sink",
			"Deli In Front Left Of Single Door",
			"Deli Prep",
			"Dock",
			"Dressing Room",
			"East Field",
			"East Greenhouse",
			"East North Of House",
			"East Of Building",
			"East Of Building B",
			"East Of Entrance Next To Light Pole",
			"East Of Entrance North Of Building In Manhole",
			"East Of Entrance West Of Sign",
			"East Of Playground",
			"East Of Round About In Valve Box",
			"East Of South Building",
			"East Of South Entrance",
			"East Of The Back Door",
			"East Restrooms Across From Startbucks",
			"East Side Inside Warehouse",
			"East Side Of Bilding",
			"East Side Of Cemetery",
			"East Side Of House",
			"East Wall In Wash Room",
			"Eest Side Of Building In Riser Room",
			"Equipment Room",
			"Far North Parking Lot Island",
			"Far South Sprinkler Box",
			"Fire Riser #12 South West Corner",
			"Fire Riser Room",
			"Fire Riser Room Front Of Building",
			"Fogger Storage Building",
			"Font Yard Along North Property Line",
			"Front By Meter",
			"Front Lawn",
			"Front Mop Room",
			"Front Ne Corner Of House",
			"Front Of Building",
			"Front Of Building Center Behind Restrooms",
			"Front Of Building South West Corner By Sidewalk",
			"Front Of House",
			"Front Of House By Stairs In Valve Box",
			"Front Of House Next To Entrance",
			"Front Of House Next To Garage Wall",
			"Front Of House South Of Steps Under Fake Rock",
			"Front Of House Under Shrubs In Valve Box",
			"Front Of Property",
			"Front Pourch",
			"Front Store East",
			"Front Store West",
			"Front Yard",
			"Front Yard By Step",
			"Front Yard Ne Corner Of Property",
			"Furnace Room",
			"Garden Center",
			"Green House North Side",
			"I Vavle Box By Metter",
			"In Back Of Service Center By Service Door Northwest End Of Building",
			"In Box East Side Of Building By Water Meter.",
			"In Ceiling Infront Of Vent Hood",
			"In Fire Riser Room",
			"In Front  Of House",
			"In Front By Prking Lot",
			"In Front By Sidewalk",
			"In Front Of Apartments",
			"In Front Of Building",
			"In Front Of House",
			"In Front Of House By Stop & Waste In Valve Box",
			"In Front Of North West Corner Front Of House",
			"In Front Of Steps Going Up To Front Door",
			"In Front Yard",
			"In Manhole Buried Just South Of Water Meter By Waterfall",
			"In North West Basement Bedroom In South Wall",
			"In Park Stip Along 1300 East",
			"In Park Strip Along 2nd N In Valve Box",
			"In Park Strip Along Road In Valve Box",
			"In Park Strip Between Entrances",
			"In Park Strip By East Enterance",
			"In Park Strip South Of North Entrance",
			"In Park Strip South Of Riverdale Road In Valve Box",
			"In Parking Lot Island In Front  Of Building In Valve Box",
			"In Parking Lot Island In Front Of Building In Valve Box",
			"In Parking Lot Island South Of The Building",
			"In Parking Lot Island South Of The Building In Valve Box",
			"In Parkstrip By Sign",
			"In Parkstrip South Of Bus Stop North Box",
			"In Parkstrip South Of Bus Stop South Box",
			"In Shop On West Wall Between Garage Doors",
			"In Shrub Bed South Of Building",
			"In The Park Strip Near The Hillfield Enterence In A Valvebox",
			"In Valve Box Within Island South Of Parking Lot",
			"In Vault N Of Building B",
			"Independent Living Exterior Mechanical Room",
			"Infornt Of Building",
			"Infront By Meter",
			"Infront Of Buiding",
			"Infront Of Build By Meter",
			"Infront Of Building South Side",
			"Infront Of House",
			"Infront Of Unit #11",
			"Infront Of Unit #12",
			"Infront Of Unit 12",
			"Infront Of Unit 49",
			"Infront Of Unit 88",
			"Infront Of Unit By Meter",
			"Inside Building On East Side",
			"Inside Fire Riser Room",
			"Inside Main Building Utility Room",
			"Inside The Building North Of The Parking Lot",
			"Inside The Building North West Of Parking Lot",
			"Inside The Parking Garage",
			"Inside West Side Of Building",
			"Island Infront South Of Driveway",
			"Island West Parking Lot",
			"Main Building",
			"Manhole By Entrance",
			"Manhole In Street",
			"Meat",
			"Meat Back Next To Washing Sink",
			"Meat Department",
			"Meat Department Counter",
			"Meat Dept",
			"Meat Dept. Backroom Triple Sink",
			"Meat Front Next To Sink",
			"Meat Packaging Under Sink",
			"Meat Seafood Washroom",
			"Mechanical Room",
			"Mechanical Room West Sid Eof Building On North End",
			"Memory Care Builidng Fire Riser Closet East Side",
			"Men's Public Restroom Back Wall",
			"Mezzanine South East Side",
			"Ne Corner Of Building",
			"Ne Of Silver Summit And Sagebrook",
			"Next To Front Steps",
			"Next To South Entrance",
			"Next To The Garage By Front Porch Behind Shrubs",
			"North Building Boiler Room",
			"North By Portables",
			"North East Comer Of Building",
			"North East Comer Of Building On State Street",
			"North East Corner Of Building",
			"North East Corner Of Building In Service Area",
			"North East Corner Of House Under Deck",
			"North East Of 4875 �Quail Lane",
			"North East Of Building",
			"North End Of Park",
			"North Enterance In Shrub Bed",
			"North Front Porch, Lower Tier Of Retaining Wall",
			"North Of  4846 Chucker",
			"North Of 4951  Partridge",
			"North Of Building",
			"North Of Building Along Sidewalk",
			"North Of Building West Of Entrance On North",
			"North Of Entrance�At 3190 S Steet On 1100 East",
			"North Of House",
			"North Of Pool House",
			"North Of Smoke Stack",
			"North Of Unit #2",
			"North Of Unit #28",
			"North Of Unit #4",
			"North Of Unit 194",
			"North Of West Wall At Entrance",
			"North Parking Lot",
			"North Pop Dispenser",
			"North Restrooms",
			"North Side",
			"North Side Of Building",
			"North Side Of House",
			"North Side Of House Behind Fence",
			"North Side Of House By Gas Meter",
			"North Side Of House By Side Walk",
			"North Side Of House In Valve Box",
			"North Side Of Sign In Front",
			"North Trail",
			"North Wall On Mezzanine",
			"North West Corner Of Building",
			"North West Corner Of Field",
			"North West Of Building",
			"North West Of Building South �Of Loading Dock",
			"Northeast Corner",
			"Northeast Corner Of Buildign",
			"Northeast Corner Of Home",
			"Northwest Of Unit #C16 By Water Meter",
			"Nw Corner Of Builing In Lab",
			"Nw Corner Of Builing Outside",
			"Nw Of Front Porch",
			"Nw Side Of Builidng",
			"On South Side Of House",
			"Outside Boiler Room",
			"Outside Boiler Room West Wall",
			"Outside By North East Corner Of Building",
			"Outside Of South East Corner Of Main Building",
			"Outside Room South West Corner Of Building",
			"Park Strip  In Front Along Curb",
			"Park Strip N Of Sign",
			"Park Strip West Of 1050 West In Valve Box",
			"Parkstrip Along 3300 S",
			"Parkstrip On Main Street",
			"Pharmacy East Restrooms",
			"Pond",
			"Pond Building",
			"Produce Backroom",
			"Produce Department Ne Corner Behind Panel In Wall",
			"Produce Department West Wall",
			"Produce Dept",
			"Produce Dry Room Bottom",
			"Produce Dry Room Top",
			"Produce Under Sink",
			"Pump Room",
			"Rear Center Of Building 2' From Main",
			"Receiving Docks",
			"Repeat",
			"Right Of The Front Door",
			"Riser Room",
			"Riser Room Back Of Building",
			"Riser Room Rear Of Building",
			"Roof Boiler Room",
			"S Of Building In Green Cage",
			"S Of Front Porch",
			"Se Of Silver Summit And East Fox Crest",
			"Seafood",
			"Shop",
			"Shrub Bed Under Sign North East Corner",
			"Shrub Bed West Side Of Property",
			"Side Of Unit",
			"Soccer Field",
			"South Across The Driveway From Unit #A6 By Water Meter",
			"South Building Boiler Room",
			"South East  4895 Knollwood",
			"South East Corner Of Building",
			"South East Corner Of Building East Of Cooler",
			"South East Corner Of Building Fire Riser Room",
			"South East Corner Of House",
			"South East Corner Of Property",
			"South East Of Round About In Valve Box",
			"South East Side 61",
			"South East Side Of Bilding",
			"South East Side Of Shop",
			"South East Wall",
			"South End Of Park",
			"South End Of Property Along 150 South",
			"South House",
			"South Of Building",
			"South Of Building In Valve Box",
			"South Of Building Outside",
			"South Of Car Wash On East Side Of Driveway",
			"South Of Entrance In Shrub Bed",
			"South Of House",
			"South Of Unit #12",
			"South Of Unit #14",
			"South Of Unit #16",
			"South Of Unit #2",
			"South Of Unit #22",
			"South Of Unit #30",
			"South Of Unit #30 By Water Meter",
			"South On Entrance In Park Strip",
			"South Park Stip, N Side S Of Sidewalk Along 3300 S",
			"South Part Of Lawn Area Along Roadway",
			"South Pop Dispenser",
			"South Restrooms",
			"South Side",
			"South Side Along Antelope",
			"South Side Of Building",
			"South Side Of Building In Valve Box",
			"South Side Of Entrance In Valve Box",
			"South Side Of House",
			"South Wall Back Room",
			"South West Corner Against Building",
			"South West Corner Of Building",
			"South West Corner Of Field",
			"South West Corner Of Property",
			"South West Corner Of The Property",
			"South West Corrner Of Basment In Wall",
			"South West Entrance",
			"South West Of Building",
			"South West Of Unit 11",
			"Southeast Cornner Of Building",
			"Starbucks Bottom Unit Under Cabinet",
			"Starbucks Top Unit Under Cabinet",
			"Steam Table",
			"Strip Of Grass Along Property South Of Building",
			"Sushi Back Room Next To Sink",
			"Sw Corner Of Building",
			"Sw Of Highland And Sagebook",
			"Top Of Hill West Of Meter By Fence",
			"Trail Head On Fox Crest Dr",
			"Under Front Stairs",
			"Under Salad Bar",
			"Under Serving Table",
			"Under The Bay Window In Ground East Of House",
			"Upstairs Storage",
			"Utility Room",
			"Utility Room In Center Of Building",
			"Utility Room On First Floor",
			"Utility Room South Side Of Building",
			"Valve Box Between Buildings By Meter",
			"Valve Box By Meter",
			"Valve Box East Of Building",
			"Valve Box In Back Yard",
			"Valve Box In Center Of Parking Strip",
			"Valve Box In East Parking Strip",
			"Valve Box In Front Yard",
			"Valve Box In Island North West Corner Of Building",
			"Valve Box In Park Strip Along Redwood Rd",
			"Valve Box North East Corner In Shrub Bed",
			"Valve Box On North Side Of House",
			"Valve Box South Of Building",
			"Valve Box South West Corner Of Building",
			"Valve Box South West Corner Of Building Along 1900 W",
			"Valve Box South West Corner Of Building In Park Strip",
			"Vehicle Storage Building",
			"Vehicle Storage Building Wash Bay",
			"Wash Room",
			"Water Heater Room",
			"West 6",
			"West Driveway Entrance",
			"West Of Apartments",
			"West Of Building",
			"West Of Mail Box, North Side Of Entrance",
			"West Of Sidewalk West Of Falls",
			"West Of Trail",
			"West Of Unit #8",
			"West Parkstip Next To Fence",
			"West Property Line About 40 Ft Away From Sidewalk",
			"West Restrooms",
			"West Side Along 1200 W",
			"West Side By Sidewalk In Valve Box",
			"West Side Of Building",
			"West Side Of Building South Door",
			"West Side Of Builting By Road",
			"West Side Of Cemetery",
			"West Side Of Field",
			"West Side Of House",
			"West Side Of House In Valve Box",
			"West Side Of Property",
			"West Side Of Property By Meter",
			"West Wall Back Room",
			"West Warehouse",
			"Women's Public Restroom"
        ];
        foreach($properties as $property){
            $client_contacts = Contact::whereHas('clients', function($q) use ($property){
                $q->where('client_id', $property->client_id);
            })->pluck('id')->toArray();
            $acount = rand(1,19);
            $month = $faker->numberBetween(1,12);
            for($assembly_count = 0;$assembly_count<$acount;$assembly_count++){
                $assembly = BackflowAssembly::create([
                    'property_id' => $property->id,
                    'contact_id' => $faker->randomElement($client_contacts),
                    'backflow_type_id' => $faker->randomElement($backflow_types),
                    'backflow_water_system_id' => $faker->randomElement($backflow_water_systems),
                    'use' => $faker->randomElement($uses),
                    'backflow_manufacturer_id' => $faker->randomElement($backflow_manufacturers),
                    'backflow_model_id' => $faker->randomElement($backflow_models),
                    'placement' => $faker->randomElement($placements),
                    'backflow_size_id' => $faker->randomElement($backflow_sizes),
                    'serial_number' => $faker->regexify('[\w-]{3,9}'),
                    'month' => $month,
                    'notes' => $faker->text
                ]);
                $rcount = rand(1,10);
                $current_year = date('Y');
                for($report_year = $current_year - $rcount;$report_year<=$current_year;$report_year++){
                    $date = $faker->dateTimeBetween("$report_year-$month-1","$report_year-$month-31",);
                    $report = BackflowTestReport::create([
                        'backflow_assembly_id' => $assembly->id,
                        'visual_inspection_notes' => $faker->text,
                        'backflow_installed_to_code' => true,
                        'report_date' => $date->format('Y-m-d'),
                        'submitted_date' => $date->format('Y-m-d')
                    ]);
                    $test_amount = rand (0,10);
                    $test_amount = $test_amount < 5 ? $test_amount : 1;
                    for($test_count = 0;$test_count<$test_amount;$test_count++){
                        $test = BackflowTest::create([
                            'backflow_test_report_id' => $report->id,
                            'contact_id' => $faker->randomElement($client_contacts),
                            'reading_1' => $faker->randomFloat(1,0,4),
                            'reading_2' => $faker->randomFloat(1,0,4),
                            'passed' => true,
                            'tested_on' => $date->format('Y-m-d')
                        ]);
                    }
                    if($test_amount > 1){
                        $valves = $assembly->backflow_type->backflow_super_type->backflow_valves;
                        foreach($valves as $valve){
                            $valve_parts = $valve->backflow_valve_parts->pluck('id')->toArray();
                            $test_amount = rand (0,4);
                            for($test_count = 0;$test_count<$test_amount;$test_count++){
                                $test = BackflowRepair::create([
                                    'backflow_test_report_id' => $report->id,
                                    'contact_id' => $faker->randomElement($client_contacts),
                                    'backflow_valve_id' => $valve->id,
                                    'backflow_valve_part_id' => $faker->randomElement($valve_parts),
                                    'repaired_on' => $date->format('Y-m-d')
                                ]);
                            }
                            $test_amount = rand (0,4);
                            for($test_count = 0;$test_count<$test_amount;$test_count++){
                                $test = BackflowCleaning::create([
                                    'backflow_test_report_id' => $report->id,
                                    'contact_id' => $faker->randomElement($client_contacts),
                                    'backflow_valve_id' => $valve->id,
                                    'backflow_valve_part_id' => $faker->randomElement($valve_parts),
                                    'cleaned_on' => $date->format('Y-m-d')
                                ]);
                            }
                        }
                    }
                    $date->modify('-1 year');
                }
            }
        }
    }
            
}
