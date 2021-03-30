<?php

namespace App\Http\Controllers;

use App\BackflowTestReport;
use App\BackflowRepair;
use App\BackflowCleaning;
use App\BackflowValvePart;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Log;

class BackflowTestReportController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowTestReport::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $values['submitted_date'] = isset($values['submitted_date']) && $values['submitted_date'] != "" ? $values['submitted_date'] : null;
        $item = BackflowTestReport::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_test_report.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item_query = BackflowTestReport::with($includes);
        $item_query->with(['backflow_tests'=> function ($q) {
            $q->orderBy('id');
        }]);
        $item = $item_query->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTestReport::findOrFail($id);
        $values = $this->validateModel($request);
        if(isset($values['submitted_date'])){
            $values['submitted_date'] = $values['submitted_date'] != "" ? $values['submitted_date'] : null;  //fix with middleware
        }
        $item->update($values);
        return ['data' => $item];
    }
    
    public function updateRepairs($id, Request $request)
    {
        $item = BackflowTestReport::findOrFail($id);
        $parts = $request->input('parts');
        $valve_id = $request->input('valve_id');
        $contact_id = $request->input('contact_id');
        $repaired_on = $request->input('repaired_on');
        if(!is_array($parts)){
            Log::debug($parts);
            return response(['message' => 'Invalid parts array:'.print_r($parts,true)], 400);
        }
        BackflowRepair::where('backflow_test_report_id',$item->id)->where('backflow_valve_id',$valve_id)->delete();
        foreach($parts as $part_id){
            BackflowRepair::create([
                'backflow_test_report_id' => $item->id,
                'contact_id' => $contact_id,
                'backflow_valve_id' => $valve_id,
                'backflow_valve_part_id' => $part_id,
                'repaired_on' => $repaired_on
            ]);
        }
        return ['data' => $item];
    }
    
    public function updateCleanings($id, Request $request)
    {
        $item = BackflowTestReport::findOrFail($id);
        $parts = $request->input('parts');
        if(!is_array($parts)){
            Log::debug($parts);
            return response(['message' => 'Invalid parts array:'.print_r($parts,true)], 400);
        }
        $valve_id = $request->input('valve_id');
        $contact_id = $request->input('contact_id');
        $cleaned_on = $request->input('cleaned_on');
        BackflowCleaning::where('backflow_test_report_id',$item->id)->where('backflow_valve_id',$valve_id)->delete();
        foreach($parts as $part_id){
            BackflowCleaning::create([
                'backflow_test_report_id' => $item->id,
                'contact_id' => $contact_id,
                'backflow_valve_id' => $valve_id,
                'backflow_valve_part_id' => $part_id,
                'cleaned_on' => $cleaned_on
            ]);
        }
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTestReport::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function htmlHeader(){
        $html = "
            <!DOCTYPE html>
            <head>
                <style>
                    body {
                        font-size: 12pt;
                        font-family: arial;
                    }
                    table {
                        border: 5px solid black;
                        border-collapse: collapse;
                        width: 100%;
                        vertical-align: top;
                    }
                    tr {
                        border: 1px solid black;
                    }
                    td {
                        border: 1px solid black;
                        vertical-align: top;
                    }
                    .plain {
                        border: 0px solid black;
                        font-size: 10pt;
                    }
                    .plain tr{
                        border: 0px solid black;
                    }
                    .plain td{
                        border: 0px solid black;
                    }
                    .plain-test {
                        border: 0px solid black;
                    }
                    .plain-test tr{
                        border: 0px solid black;
                    }
                    .plain-test td{
                        border: 0px solid black;
                    }
                    .header {
                        font-weight: bold;
                        text-align: right;
                    }
                    .info {
                        padding: 2px;
                    }
                    .underline {
                        text-decoration: underline;
                    }
                </style>
            </head>
            <body>
        ";
        return $html;
    }
    
    public function htmlFooter(){
        $html = "
        </body>
            </html>
        ";
        return $html;
    }
    
    public function html($id, Request $request){
        $html = $this->htmlHeader();
        $html .= $this->htmlBody($id, $request);
        $html .= $this->htmlFooter();
        return $html;
    }
    
    static public function formatPSI($psi, $padding = 4){
        $formatted = $psi;
        if(is_numeric($psi)){
            $formatted = sprintf('%03.1f',$psi);
        }
        else{
            $padding--;
        }
        for($x=strlen($formatted);$x<$padding;$x++){
            $formatted='&nbsp;'.$formatted;
        }
        return $formatted;
    }
    
    static public function formatString($string, $padding = 4){
        $formatted = $string;
        for($x=strlen($formatted)*2;$x<$padding;$x++){
            $formatted.='&nbsp;';
        }
        return $formatted;
    }
    
    static public function checked($checked){
        if($checked){
            return 'checked="checked"';
        }
        else{
            return '';
        }
    }
    
    static public function testResults($super_type,$test){
        $results = [
            'RP' =>  [
                'check_1' => [
                    'PSI' => '',
                    'closed_tight' => false,
                    'leaked' => false
                ],
                'check_2' => [
                    'PSI' => '',
                    'closed_tight' => false,
                    'leaked' => false
                ],
                'differential' => [
                    'opened_at' => '',
                    'opened_under' => false,
                    'did_not_open' => false
                ],
            ],
            'DC' => [
                'check_1' => [
                    'PSI' => '',
                    'closed_tight' => false,
                    'leaked' => false
                ],
                'check_2' => [
                    'PSI' => '',
                    'closed_tight' => false,
                    'leaked' => false
                ]
            ],
            'PVB' => [
                'check' => [
                    'PSI' => '',
                    'closed_tight' => false,
                    'leaked' => false
                ],
                'air_inlet' => [
                    'opened_at' => '',
                    'opened_under' => false,
                    'did_not_open' => false
                ],
            ],
            'satisfactory' => $test ? $test->passed : false,
            'unsatisfactory' => $test ? !$test->passed : false
        ];
        if(!$test){
            return $results;
        }
        switch ($super_type){
            case 'RP' :
                $results['RP']=self::RPTestResults($test);
                break;
            case 'DC' :
                $results['DC']=self::DCTestResults($test);
                break;
            case 'PVB' :
                $results['PVB']=self::PVBTestResults($test);
                break;
        }
        return $results;
    }
    
    static public function RPTestResults($test){
        $results = [
            'check_1' => self::RPTestCheck1Results($test),
            'check_2' => self::RPTestCheck2Results($test),
            'differential' => self::RPTestDifferentialResults($test)
        ];
        return $results;
    }
    
    static public function PVBTestResults($test){
        $results = [
            'check' => self::PVBTestCheckResults($test),
            'air_inlet' => self::PVBTestAirInletResults($test)
        ];
        return $results;
    }
    
    static public function RPTestCheck1Results($test){
        $results = [
            'PSI' => $test['reading_1'] < $test['reading_2'] ? $test['reading_2'] : "N/A",
            'closed_tight' => $test['reading_1'] < $test['reading_2'],
            'leaked' => $test['reading_2'] == ""
        ];
        return $results;
    }
    
    static public function RPTestCheck2Results($test){
        $results = [
            'PSI' => $test['reading_1'] < $test['reading_2'] ? 'OK' : null,
            'closed_tight' => $test['reading_1'] < $test['reading_2'],
            'leaked' => $test['reading_1'] && strlen($test['reading_2']) ? $test['reading_1'] >= $test['reading_2'] : false
        ];
        return $results;
    }
    
    
    static public function DCTestResults($test){
        $results = [
            'check_1' => self::DCTestCheck1Results($test),
            'check_2' => self::DCTestCheck2Results($test)
        ];
        return $results;
    }
    
    static public function DCTestCheck1Results($test){
        $results = [
            'PSI' => $test['reading_1'],
            'closed_tight' => $test['reading_1'] >= 1,
            'leaked' => $test['reading_1'] < 1
        ];
        return $results;
    }
    
    static public function DCTestCheck2Results($test){
        $results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => $test['reading_2'] >= 1,
            'leaked' => $test['reading_2'] < 1
        ];
        return $results;
    }
    
    static public function RPTestDifferentialResults($test){
        $results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => $test['reading_1'] < 2 && $test['reading_1'] > 0,
            'did_not_open' => $test['reading_1'] == 0
        ];
        return $results;
    }
    
    static public function PVBTestAirInletResults($test){
        $results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => $test['reading_1'] < 1 && $test['reading_1'] >0,
            'did_not_open' => $test['reading_1'] <= 0
        ];
        return $results;
    }
    
    static public function PVBTestCheckResults($test){
        $results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => $test['reading_2'] >= 1,
            'leaked' => $test['reading_2'] < 1
        ];
        return $results;
    }
    
    static public function contactFormat($test){
        $contact = [
            'name' => '',
            'cert' => '',
            'date' => ''
        ];
        if(!$test){
            return $contact;
        }
        $contact['name'] = $test->contact->name ?? '(none)';
        $contact['cert'] = $test->contact->backflow_certification_number ?? '(none)';
        $contact['date'] = date('m-d-Y',strtotime($test->tested_on ?? $test->cleaned_on ?? $test->repaired_on));
//        $contact['date'] = date('m-d-Y',strtotime($test->tested_on));
        return $contact;
    }
    
    public function htmlBody($id, Request $request)
    {
        $report = BackflowTestReport::with('backflow_tests','backflow_assembly','backflow_assembly.property','backflow_assembly.property.client','backflow_assembly.backflow_water_system', 'backflow_assembly.backflow_manufacturer')->findOrFail($id);
        $billing_property = $report->backflow_assembly->property->client->billingProperty;
        if(!$billing_property){
            $billing_property = $report->backflow_assembly->property;
        }
        $property = $report->backflow_assembly->property;
        $initial = $report->backflow_tests()->orderBy('id')->first();
        $final = null;
        if($report->backflow_tests->count() > 1){
            $final = $report->backflow_tests()->orderBy('id', 'DESC')->first();
        }
        $first_parts=BackflowValvePart::whereHas('backflow_valve', function($q){
            $q->where('name', '=', 'First');
        })->orderBy('id')->get();
        $second_parts=BackflowValvePart::whereHas('backflow_valve', function($q){
            $q->where('name', '=', 'Second');
        })->orderBy('id')->get();
        $relief_parts=BackflowValvePart::whereHas('backflow_valve', function($q){
            $q->where('name', '=', 'Differential Pressure Relief');
        })->orderBy('id')->get();
        $breaker_parts=BackflowValvePart::whereHas('backflow_valve', function($q){
            $q->where('name', '=', 'Pressure Vacuum Breaker');
        })->orderBy('id')->get();
        $inlet_parts=BackflowValvePart::whereHas('backflow_valve', function($q){
            $q->where('name', '=', 'Air Inlet');
        })->orderBy('id')->get();
        $first_repairs=BackflowRepair::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'First');
            })->pluck('backflow_valve_part_id')->toArray();
        $second_repairs=BackflowRepair::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Second');
            })->pluck('backflow_valve_part_id')->toArray();
        $relief_repairs=BackflowRepair::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Differential Pressure Relief');
            })->pluck('backflow_valve_part_id')->toArray();
        $breaker_repairs=BackflowRepair::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Pressure Vacuum Breaker');
            })->pluck('backflow_valve_part_id')->toArray();
        $inlet_repairs=BackflowRepair::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Air Inlet');
            })->pluck('backflow_valve_part_id')->toArray();
        $first_cleanings=BackflowCleaning::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'First');
            })->pluck('backflow_valve_part_id')->toArray();
        $second_cleanings=BackflowCleaning::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Second');
            })->pluck('backflow_valve_part_id')->toArray();
        $relief_cleanings=BackflowCleaning::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Differential Pressure Relief');
            })->pluck('backflow_valve_part_id')->toArray();
        $breaker_cleanings=BackflowCleaning::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Pressure Vacuum Breaker');
            })->pluck('backflow_valve_part_id')->toArray();
        $inlet_cleanings=BackflowCleaning::where('backflow_test_report_id', '=', $id)
            ->whereHas('backflow_valve', function($q){
                $q->where('name', '=', 'Air Inlet');
            })->pluck('backflow_valve_part_id')->toArray();
        $super_type = $report->backflow_assembly->backflow_type->backflow_super_type->name;
        $initial_test_results = self::testResults($super_type,$initial);
        $final_test_results = self::testResults($super_type,$final);
        $initial_contact = self::contactFormat($initial);
        $final_contact = self::contactFormat($final);
        $first_repair = BackflowRepair::where('backflow_test_report_id', '=', $id)->first();
        if($first_repair == null){
            $first_repair=BackflowCleaning::where('backflow_test_report_id', '=', $id)->first();
        }
        $repair_contact = self::contactFormat($first_repair);
        $number = "";
        $backflow_assembly_contact_name = "";
        if($report->backflow_assembly->contact){
            $backflow_assembly_contact_name = $report->backflow_assembly->contact->name;
            $numbers = $report->backflow_assembly->contact->phoneNumbers;
            if($numbers->first()){
                $number = $numbers->first()->phone_number;
            }
        }
        $super_type_result = $super_type == "PVB" ? 'RP' : $super_type;
        $html = '
                <div style="text-align:center"><h3>Backflow Assembly Test Report</h3></div>
                <div style="float:left;width:68%;font-size:11px;padding:5px;">
                    <div class="info"><span class="header">Water System:</span> ' . $report->backflow_assembly->backflow_water_system->name . '</div>
                    <div class="info"><span class="header">Owner:</span> ' . $property->client->name . '&nbsp;&nbsp;&nbsp;<span class="header">Contact Person:</span> ' . $backflow_assembly_contact_name . '&nbsp;&nbsp;&nbsp;<span class="header">Phone:</span> ' . $number . '</div>
                    <div class="info"><span class="header">Address:</span> ' . $billing_property->address1 . ' ' . $billing_property->address_2 . '&nbsp;&nbsp;&nbsp;<span class="header">City:</span> ' . $billing_property->city . '&nbsp;&nbsp;&nbsp;<span class="header">State:</span> ' . $billing_property->state . '&nbsp;&nbsp;&nbsp;<span class="header">Zip:</span> ' . $billing_property->zip . '</div>
                    <br />
                    <div class="info"><span class="header">Assembly Location:</span> ' . $property->name . '</div>
                    <div class="info"><span class="header">Address:</span> ' . $report->backflow_assembly->property->address1 . ' ' . $report->backflow_assembly->property->address_2 . '&nbsp;&nbsp;&nbsp;<span class="header">City:</span> ' . $report->backflow_assembly->property->city . '&nbsp;&nbsp;&nbsp;<span class="header">State:</span> ' . $report->backflow_assembly->property->state . '&nbsp;&nbsp;&nbsp;<span class="header">Zip:</span> ' . $report->backflow_assembly->property->zip . '</div>
                    <br />
                    <div class="info"><span class="header">Assembly Placement:</span> ' . $report->backflow_assembly->placement . '&nbsp;&nbsp;&nbsp;<span class="header">Use:</span> ' . $report->backflow_assembly->use . '</div>
                    <div class="info">' . $report->backflow_assembly->notes . '</div>
                    <div class="info"><span class="header">Assembly Style:</span> ' . $report->backflow_assembly->backflow_type->name . '&nbsp;&nbsp;&nbsp;<span class="header">Manufacturer:</span> ' . $report->backflow_assembly->backflow_manufacturer->name . '</div>
                    <div class="info"><span class="header">Size:</span> ' . $report->backflow_assembly->backflow_size->name . '"&nbsp;&nbsp;&nbsp;<span class="header">Model:</span> ' . $report->backflow_assembly->backflow_model->name . '&nbsp;&nbsp;&nbsp;<span class="header">Serial No.:</span> ' . $report->backflow_assembly->serial_number . '</div>
                    <div class="info"><span class="header">Proper installation and use:</span> ' . ($report->backflow_installed_to_code ? 'To Code' : 'Not To Code') . '</div>
                    <div class="info"><span class="header">Visual inspection notes:</span> ' . $report->visual_inspection_notes . ' </div>
                </div>
                <div style="float:right;width:29%;text-align:center;font-size: 8pt;padding:5px;">
                    <img src="/api/images/w_logo.jpg" style="width:100%;" />
                    BACKFLOW TESTING<br />
                    98 SOUTH 2200 WEST<br />
                    LAYTON UTAH 84041<br />
                    801-546-0844<br />
                    ' . $initial_contact['name']  . '<br />
                    CERTIFICATION # '.$initial_contact['cert'].'<br />
                    WatersContracting1985@gmail.com<br />
                </div>
                <br style="clear:left;"/>
                <table>
                    <tr>
                        <td rowspan="3">
                            I<br />
                            N<br />
                            I<br />
                            T<br />
                            I<br />
                            A<br />
                            L
                        </td>
                        <td colspan="2" style="text-align: center;vertical-align: bottom;">
                            Check Valve #1
                        </td>
                        <td style="text-align: center;vertical-align: bottom;">
                            Check Valve #2
                        </td>
                        <td style="text-align: center;vertical-align: bottom;">
                            Differential Pressure Relief Valve
                        </td>
                        <td style="text-align: center;vertical-align: bottom;">
                            Pressure Vacuum Breaker
                        </td>
                    </tr>
                    <tr>
                        <td>
                            RP
                        </td>
                        <td>
                            PSI Across <span class="underline">' . self::formatPSI($initial_test_results['RP']['check_1']['PSI']) . '</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Closed tight
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['check_1']['closed_tight']).' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Leaked
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['check_1']['leaked']).' />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            PSI Across <span class="underline">'.self::formatPSI($initial_test_results['RP']['check_2']['PSI']).'</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Closed tight
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['check_2']['closed_tight']).'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Leaked
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['check_2']['leaked']).'>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            Opened At <span class="underline">'.self::formatPSI($initial_test_results['RP']['differential']['opened_at']).'</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Opened Under 2#
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['differential']['opened_under']).'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        or did not open
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" '.self::checked($initial_test_results['RP']['differential']['did_not_open']).'>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            AIR INLET:<br />
                            Opened at <span class="underline">' . self::formatPSI($initial_test_results['PVB']['air_inlet']['opened_at']) . '</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Opened Under 1#
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['PVB']['air_inlet']['opened_under']) . '>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        or did not open
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['PVB']['air_inlet']['did_not_open']) . '>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DC
                        </td>
                        <td>
                            Held at <span class="underline">' . self::formatPSI($initial_test_results['DC']['check_1']['PSI']) . '</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Closed tight
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['DC']['check_1']['closed_tight']) . '>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Leaked
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['DC']['check_1']['leaked']) . '>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            Held at <span class="underline">' . self::formatPSI($initial_test_results['DC']['check_2']['PSI']) . '</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Closed tight
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['DC']['check_2']['closed_tight']) . '>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Leaked
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['DC']['check_2']['leaked']) . '>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                        </td>
                        <td>
                            CHECK VALVE:<span class="underline">' . self::formatPSI($initial_test_results['PVB']['check']['PSI']) . '</span>#<br />
                            <table class="plain-test">
                                <tr>
                                    <td>
                                        Closed tight
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['PVB']['check']['closed_tight']) . '><br style="clear:right;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Leaked
                                    </td>
                                    <td>
                                        <input style="float:right;" type="checkbox" ' . self::checked($initial_test_results['PVB']['check']['leaked']) . '>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            R<br />
                            E<br />
                            P<br />
                            A<br />
                            I<br />
                            A<br />
                            R<br />
                            S<br />
                        </td>
                        <td >
                        </td>
                        <td>
                            <table class="plain">
        ';
        $checked="";
        if(count($first_cleanings)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Cleaned: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        $checked="";
        if(count($first_repairs)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Replaced: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        foreach($first_parts as $first_part){
            $checked="";
            if((in_array($first_part->id,$first_repairs))||(in_array($first_part->id,$first_cleanings))){
                $checked='checked="checked"';
            }
            $html .= '<tr><td>&nbsp;'.$first_part->name. '</td><td><input type="checkbox" style="float:right;" '.$checked.'></span></td></tr>';
        }
        $html .='
                            <tr><td>&nbsp;Other (describe)</td><td><input type="checkbox"></td></tr>
                            </table>
                        </td>
                        <td>
                            <table class="plain">
        ';
        $checked="";
        if(count($second_cleanings)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Cleaned: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        $checked="";
        if(count($second_repairs)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Replaced: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        foreach($second_parts as $second_part){
            $checked="";
            if((in_array($second_part->id,$second_repairs))||(in_array($second_part->id,$second_cleanings))){
                $checked='checked="checked"';
            }
            $html .= '<tr><td>&nbsp;'.$second_part->name. '</td><td><input type="checkbox" '.$checked.'></td></tr>';
        }
        $html .='
                            <tr><td>&nbsp;Other (describe)</td><td><input type="checkbox"></td></tr>
                            </table>
                        </td>
                        <td>
                            <table class="plain">
        ';
        $checked="";
        if(count($relief_cleanings)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Cleaned: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        $checked="";
        if(count($relief_repairs)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Replaced: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        foreach($relief_parts as $relief_part){
            $checked="";
            if((in_array($relief_part->id,$relief_repairs))||(in_array($relief_part->id,$relief_cleanings))){
                $checked='checked="checked"';
            }
            $html .= '<tr><td>&nbsp;'.$relief_part->name. '</td><td><input type="checkbox" '.$checked.'></td></tr>';
        }
        $html .='
                            <tr><td>&nbsp;Other (describe) </td><td><input type="checkbox"></td></tr>
                            </table>
                        </td>
                        <td>
                            <table class="plain">
        ';
        $checked="";
        if(count($breaker_cleanings)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Cleaned: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        $checked="";
        if(count($breaker_repairs)){
            $checked='checked="checked"';
        }
        $html .= '<tr><td>Replaced: </td><td><input type="checkbox" '.$checked.'></td></tr>';
        foreach($breaker_parts as $breaker_part){
            $checked="";
            if(in_array($breaker_part->id,$breaker_repairs) || in_array($breaker_part->id,$breaker_cleanings)){
                $checked='checked="checked"';
            }
            $html .= '<tr><td>&nbsp;'.$breaker_part->name. '</td><td><input type="checkbox" '.$checked.'></td></tr>';
        }
        $html .='
                            <tr><td>&nbsp;Other (describe) </td><td><input type="checkbox"></td></tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                           FINAL TEST
                        </td>
                        <td>
                            PSI Across <span class="underline">' . self::formatPSI($final_test_results[$super_type_result]['check_1']['PSI']) . '</span>#<br />
                            Closed Tight <input type="checkbox" ' . self::checked($final_test_results[$super_type_result]['check_1']['closed_tight']) . '><br />
                        </td>
                        <td>
                            PSI Across <span class="underline">' . self::formatPSI($final_test_results[$super_type_result]['check_2']['PSI']) . '</span>#<br />
                            Closed Tight <input type="checkbox" ' . self::checked($final_test_results[$super_type_result]['check_2']['closed_tight']) . '><br />
                        </td>
                        <td>
                            Opened at <span class="underline">' . self::formatPSI($final_test_results['RP']['differential']['opened_at']) . '</span>#<br />
                            Reduced Pressure<br />
                        </td>
                        <td>
                            INLET Opened At <span class="underline">' . self::formatPSI($final_test_results['PVB']['air_inlet']['opened_at']) . '</span>#<br />
                            CHECK VALVE: <span class="underline">' . self::formatPSI($final_test_results['PVB']['check']['PSI']) . '</span>#<br />
                            Closed tight <input type="checkbox" ' . self::checked($final_test_results['PVB']['check']['closed_tight']) . '><br />
                        </td>
                    </tr>
                </table>
                <table class="plain" style="font-size:12pt;width:100%;">
                    <tr><td class="header" style="padding:0px;">Initial Test By:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($initial_contact['name'],42)  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($initial_contact['cert'],16)  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($initial_contact['date'],18)  . '</td></tr>
                    <tr><td class="header">Repaired By:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($repair_contact['name'],42)  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($repair_contact['cert'],16)  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($repair_contact['date'],18)  . '</td></tr>
                    <tr><td class="header">Final Test By:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($final_contact['name'],42)  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($final_contact['cert'],16)  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . self::formatString($final_contact['date'],18)  . '</td></tr>
                </table>
                <div class="info"><span class="header">Report Notes:</span>'. $report->notes .'</div>
                <div style="float:left;width:68%;font-size:11px;padding:5px;">                
                    <div class="info">This assembly\'s <span class="header">INITIAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" '.self::checked($initial_test_results['satisfactory']).'/> <span class="header">Unsatisfactory</span> <input type="checkbox" '.self::checked($initial_test_results['unsatisfactory']).'/></div>
                    <div class="info">This assembly\'s <span class="header">FINAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" '.self::checked($final_test_results['satisfactory']).' /> <span class="header">Unsatisfactory</span><input type="checkbox" /></div>
                    <div class="info">I certify the above test has been performed and I am aware of the final performance.</div>
                    <div class="info">BY: ________________________________________ Assembly Owner Representative Assembly</div>
                </div>
        ';
        return $html;
    }
    
    public function pdf($id, Request $request)
    {
        class_alias('Illuminate\Support\Facades\Config', 'Config');//needed for PDF stuff to work, but conflicts with phpunit
        $html = $this->html($id, $request);
        $html = preg_replace('|/api/images/w_logo.jpg|',public_path().'/images/w_logo.jpg',$html);
        $pdf = Pdf::loadHtml($html);
        $filename = $this->pdfName($id,$request);
        return $pdf->stream($filename . '.pdf');
    }
    
    public function htmls(Request $request)
    {
        $ids = $request->input('backflow_test_report_id');
        $html = $this->htmlHeader();
        $count = 0;
        foreach($ids as $id){
            $html .= $this->htmlBody($id, $request);
        }
        $html .= $this->htmlFooter();
        return $html;
    }

    public function pdfs(Request $request)
    {
        class_alias('Illuminate\Support\Facades\Config', 'Config');//needed for PDF stuff to work, but conflicts with phpunit
        $html = $this->htmls($request);
        $html = preg_replace('|/api/images/w_logo.jpg|',public_path().'/images/w_logo.jpg',$html);
        $pdf = Pdf::loadHtml($html);
        $ids = $request->input('backflow_test_report_id');
        $filename = $this->pdfName($ids[0],$request);
        return $pdf->stream($filename . '.pdf');
    }
    
    public function pdfName($id,$request){
        $use = $request->only(['use_client','use_property']);
        $report = BackflowTestReport::with('backflow_assembly','backflow_assembly.property','backflow_assembly.backflow_water_system')->findOrFail($id);
        $filename = '';
        if(empty($use['use_client'])||($use['use_client'] == 'true')){
            $filename = $report->backflow_assembly->property->client->abbreviation ? $report->backflow_assembly->property->client->abbreviation : $report->backflow_assembly->property->client->name;
            $filename .= ' ';
        }
        if(empty($use['use_property'])||($use['use_property'] == 'true')){
            $filename .= $report->backflow_assembly->property->abbreviation ? $report->backflow_assembly->property->abbreviation : $report->backflow_assembly->property->name;
            $filename .= ' ';
        }
        $filename .= $report->backflow_assembly->backflow_water_system->abbreviation ? $report->backflow_assembly->backflow_water_system->abbreviation : $report->backflow_assembly->backflow_water_system->name;
        $filename .= ' '.$report->report_date;
        return $filename;
    }

    protected $model_validation = [
       'backflow_assembly_id' => 'integer|exists:backflow_assemblies,id',
       'visual_inspection_notes' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
       'backflow_installed_to_code' => 'boolean',
       'report_date' => 'date',
       'submitted_date' => 'date|nullable',
       'tag_year' => 'string|max:4|nullable'
    ];
    
    protected $model_validation_required = [
       'backflow_assembly_id' => 'required',
       'backflow_installed_to_code' => 'required',
       'report_date' => 'required'
    ];

    protected $model_includes = [
       'backflow_assembly',
       'backflow_assembly.property',
       'backflow_assembly.property.client',
       'backflow_assembly.backflow_type',
       'backflow_assembly.backflow_type.backflow_super_type',
       'backflow_assembly.backflow_test_reports',
       'backflow_assembly.backflow_test_reports.backflow_tests',
       'backflow_tests',
       'backflow_repairs',
       'backflow_cleanings'
    ];
    
}
