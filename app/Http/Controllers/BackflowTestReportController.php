<?php

namespace App\Http\Controllers;

use App\BackflowTestReport;
use App\BackflowRepair;
use App\BackflowCleaning;
use App\BackflowValvePart;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

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
        $item = BackflowTestReport::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_test_report.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowTestReport::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTestReport::findOrFail($id);
        $values = $this->validateModel($request);
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
        return response([], 401);
    }
    
    public function pdf($id, Request $request)
    {
    $report = BackflowTestReport::with('backflow_tests','backflow_assembly','backflow_assembly.property','backflow_assembly.property.client','backflow_assembly.backflow_water_system')->findOrFail($id);
    $billing_property = $report->backflow_assembly->property->client->billingProperty;
    if(!$billing_property){
        $billing_property = $report->backflow_assembly->property;
    }
    $property = $report->backflow_assembly->property;
    $initial = $report->backflow_tests->first();
    $final = $report->backflow_tests->last();
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
    $rp_reading_1 = '';
    $rp_reading_2 = ''; 
    $rp_1_pass = '';
    $rp_2_pass = '';
    $rp_3_pass = '';
    $rp_1_fail = '';
    $rp_2_fail = '';
    $rp_3_fail = '';
    $rp_2_value = '';
    $dc_reading_1 = '';
    $dc_reading_2 = '';
    $dc_1_pass = '';
    $dc_2_pass = '';
    $dc_1_fail = '';
    $dc_2_fail = '';
    $pvb_reading_1 = '';
    $pvb_reading_2 = '';
    $pvb_1_pass = '';
    $pvb_2_pass = '';
    $pvb_1_fail = '';
    $pvb_2_fail = '';
    $final_1 = '';
    $final_2 = '';
    $final_3 = '';
    $pvb_final_1 = '';
    $pvb_final_2 = '';
    $initial_passed = '';
    $initial_failed = '';
    $pvb_final_closed = '';
    $final_1_closed = '';
    $final_2_closed = '';
    $final_3_closed = '';
    switch($report->backflow_assembly->backflow_type->name){
        case 'RP' :
        case 'RPDA' :
            $rp_reading_1 = $initial->reading_1;
            $rp_reading_2 = $initial->reading_2;
            $diff = $initial->reading_2 - $initial->reading_1;
            if($diff >= 2){
                $rp_1_pass = 'checked="checked"';
                $rp_2_pass = 'checked="checked"';
                $rp_3_pass = 'checked="checked"';
                $rp_2_value = 'OK';
                $initial_passed = 'checked="checked"';
            }
            else{
                $rp_1_fail = 'checked="checked"';
                $rp_2_fail = 'checked="checked"';
                $rp_3_fail = 'checked="checked"';
                $initial_failed = 'checked="checked"';
            }
            $final_1 = $final->reading_1;
            $final_2 = 'OK';
            $final_3 = $final->reading_2;
            $final_1_closed = 'checked="checked"';
            $final_2_closed = 'checked="checked"';
            $final_3_closed = 'checked="checked"';
            break;
        case 'DC' :
        case 'DCDA' :
            $dc_reading_1 = $initial->reading_1;
            $dc_reading_2 = $initial->reading_2;
            if($initial->reading_1 > 1){
                $dc_1_pass = 'checked="checked"';
                $initial_passed = 'checked="checked"';
            }
            else{
                $dc_1_fail = 'checked="checked"';
                $initial_failed = 'checked="checked"';
            }
            if($initial->reading_2 > 1){
                $dc_2_pass = 'checked="checked"';
            }
            else{
                $dc_2_fail = 'checked="checked"';
                $initial_passed = '';
                $initial_failed = 'checked="checked"';
            }
            $final_1 = $final->reading_1;
            $final_2 = $final->reading_2;
            $final_1_closed = 'checked="checked"';
            $final_2_closed = 'checked="checked"';
            break;
        case 'PVB' :
        case 'SVB' :
            if($initial->reading_1){
                $pvb_1_pass = 'checked="checked"';
                $initial_passed = 'checked="checked"';
            }
            else{
                $pvb_1_fail = 'checked="checked"';
                $initial_failed = 'checked="checked"';
            }
            if($initial->reading_2){
                $pvb_2_pass = 'checked="checked"';
            }
            else{
                $pvb_2_fail = 'checked="checked"';
                $initial_passed = '';
                $initial_failed = 'checked="checked"';
            }
            $pvb_reading_1 = $initial->reading_1;
            $pvb_reading_2 = $initial->reading_2;
            $pvb_final_1 = $final->reading_1;
            $pvb_final_2 = $final->reading_2;
            $pvb_final_closed = 'checked="checked"';
            break;
    }
    $html = '
        <head>
            <style>
                body {
                    font-size: 12pt;
                }
                table {
                    border: 5px double black;
                    border-collapse: collapse;
                    width: 100%;
                    vertical-align: top;
                }
                tr {
                    border: 1px double black;
                }
                tr + tr {
                    border: 1px solid black;
                }
                td {
                    border: 1px double black;
                    vertical-align: top;
                }
                td + td {
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
                .header {
                    font-weight: bold;
                }
            </style>
        <head>
        <body>
            <div style="text-align:center"><h3>Backflow Assembly Test Report</h3></div>
            <div style="border: 1px solid black;float:left;width:70%;">
                <span class="header">Water System:</span> ' . $report->backflow_assembly->backflow_water_system->name . '<br />
                <span class="header">Owner:</span> ' . $property->client->name . '<br />
                <span class="header">Contact Person:</span> ' . $report->backflow_assembly->contact->name . ' Phone: ' . $billing_property->phone_number . '<br />
                <span class="header">Address:</span> ' . $billing_property->address_1 . ' ' . $billing_property->address_2 . ' City: ' . $billing_property->city . ' State: ' . $billing_property->state . ' Zip: ' . $billing_property->zip . '<br />
                <span class="header">Assembly Location:</span> ' . $property->name . '<br />
                <span class="header">Address:</span> ' . $billing_property->address_1 . ' ' . $billing_property->address_2 . ' City: ' . $billing_property->city . ' State: ' . $billing_property->state . ' Zip: ' . $billing_property->zip . '<br />
                <span class="header">Assembly Placement:</span> ' . $report->backflow_assembly->placement . ' Use: ' . $report->backflow_assembly->use . '<br />
                <span class="header">Assembly Style:</span> ' . $report->backflow_assembly->backflow_type->name . '<br />
                <span class="header">Size:</span> ' . $report->backflow_assembly->backflow_size->name . '" Model: ' . $report->backflow_assembly->backflow_model->name . ' Serial No.: ' . $report->backflow_assembly->serial_number . '<br />
                <span class="header">Proper installation and use:</span> ' . ($report->backflow_installed_to_code ? 'To Code' : 'Not To Code') . '<br />
                <span class="header">Visual inspection notes:</span> ' . $report->visual_inspection_notes . ' <br />
            </div>
            <div style="border: 1px solid black;float:right;width:29%;text-align:center;font-size: 8pt;">
                <img src="/api/images/w_logo.jpg" style="width:100%;" />
                BACKFLOW TESTING<br />
                98 SOUTH 2200 WEST<br />
                LAYTON UTAH 84041<br />
                801-546-0844<br />
                ' . $final->contact->name  . '<br />
                CERTIFICATION # ADDTODATABASE<br />
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
                        PSI Across #' . $rp_reading_1 . '<br />
                        Closed tight <input type="checkbox" '.$rp_1_pass.'><br />
                        Leaked <input type="checkbox" '.$rp_1_fail.' />
                    </td>
                    <td>
                        PSI Across #'.$rp_2_value.'<br />
                        Closed tight <input type="checkbox" '.$rp_2_pass.'><br />
                        Leaked <input type="checkbox" '.$rp_2_fail.'>
                    </td>
                    <td>
                        Opened At #'.$rp_reading_2.'<br />
                        Opened Under 2# <input type="checkbox" '.$rp_3_pass.'><br />
                        or did not open <input type="checkbox" '.$rp_3_fail.'>
                    </td>
                    <td>
                        AIR INLET:<br />
                        Opened at ' . $pvb_reading_1 . '<br />
                        Opened Under 1# <input type="checkbox" ' . $pvb_1_pass . '><br />
                        or did not open <input type="checkbox" ' . $pvb_1_fail . '>
                    </td>
                </tr>
                <tr>
                    <td>
                        DC
                    </td>
                    <td>
                        Held at #' . $dc_reading_1 . '<br />
                        Closed tight <input type="checkbox" ' . $dc_1_pass . '><br />
                        Leaked <input type="checkbox" ' . $dc_1_fail . '>
                    </td>
                    <td>
                        Held at #' . $dc_reading_2 . '<br />
                        Closed tight <input type="checkbox" ' . $dc_2_pass . '><br />
                        Leaked <input type="checkbox" ' . $dc_2_fail . '>
                    </td>
                    <td>
                    </td>
                    <td>
                        CHECK VALVE:_#:' . $pvb_reading_2 . '<br />
                        Closed tight <input type="checkbox" ' . $pvb_2_pass . '><br />
                        Leaked <input type="checkbox" ' . $pvb_2_fail . '>
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
                        PSI Across ' . $final_1 . '<br />
                        Closed Tight <input type="checkbox" ' . $final_1_closed . '><br />
                    </td>
                    <td>
                        PSI Across ' . $final_2 . '<br />
                        Closed Tight <input type="checkbox" ' . $final_1_closed . '><br />
                    </td>
                    <td>
                        Opened at ' . $final_3 . '#<br />
                        Reduced Pressure <input type="checkbox" ' . $final_1_closed . '><br />
                    </td>
                    <td>
                        INLET Opened At ' . $pvb_final_1 . '#<br />
                        CHECK VALVE: ' . $pvb_final_2 . '#<br />
                        Closed tight <input type="checkbox" ' . $pvb_final_closed . '><br />
                    </td>
                </tr>
            </table>
            <span class="header">Initial Test By:</span> ' . $initial->contact->name  . ' Certification No. ' . $initial->contact->backflow_certification_number  . ' <span class="header">Date:</span> ' . $final->tested_on  . '<br />
            <span class="header">Repaired By:</span> ' . $final->contact->name  . ' Certification No. ' . $final->contact->backflow_certification_number  . ' <span class="header">Date:</span> ' . $final->tested_on  . '<br />
            <span class="header">Final Test By:</span> ' . $final->contact->name  . ' Certification No. ' . $final->contact->backflow_certification_number  . ' <span class="header">Date:</span> ' . $final->tested_on  . '<br />
            This assembly\'s <span class="header">INITIAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" '.$initial_passed.'/> <span class="header">Unsatisfactory</span> <input type="checkbox" '.$initial_failed.'/><br />
            This assembly\'s <span class="header">FINAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" checked="checked" /> <span class="header">Unsatisfactory</span><input type="checkbox" /><br />
            I certify the above test has been performed and I am aware of the final performance.<br />
            BY: ________________________________________ Assembly Owner Representative Assembly<br />
        </body>
        </html> 
    ';
	$pdf = Pdf::loadHtml($html);
	return $pdf->stream('backflow-report.pdf');
    }
    
    protected $model_validation = [
       'backflow_assembly_id' => 'integer|exists:backflow_assemblies,id',
       'visual_inspection_notes' => 'string|max:1020',
       'notes' => 'string|max:1020',
       'backflow_installed_to_code' => 'boolean',
       'report_date' => 'date'
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
       'backflow_tests',
       'backflow_repairs',
       'backflow_cleanings'
    ];
    
}