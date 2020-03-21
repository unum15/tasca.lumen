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
    
    
    public function htmlBody($id, Request $request)
    {
        $report = BackflowTestReport::with('backflow_tests','backflow_assembly','backflow_assembly.property','backflow_assembly.property.client','backflow_assembly.backflow_water_system', 'backflow_assembly.backflow_manufacturer')->findOrFail($id);
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
        $rp_reading_1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $rp_reading_2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
        $rp_1_pass = '';
        $rp_2_pass = '';
        $rp_3_pass = '';
        $rp_1_fail = '';
        $rp_2_fail = '';
        $rp_3_fail = '';
        $rp_2_value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $dc_reading_1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $dc_reading_2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $dc_1_pass = '';
        $dc_2_pass = '';
        $dc_1_fail = '';
        $dc_2_fail = '';
        $pvb_reading_1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $pvb_reading_2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $pvb_1_pass = '';
        $pvb_2_pass = '';
        $pvb_1_fail = '';
        $pvb_2_fail = '';
        $final_1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $final_2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $final_3 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $pvb_final_1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $pvb_final_2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $initial_passed = '';
        $initial_failed = '';
        $pvb_final_closed = '';
        $final_1_closed = '';
        $final_2_closed = '';
        $final_3_closed = '';
        $final_passed = '';
        $initial_contact_name=$initial->contact->name;
        if(30-strlen($initial->contact->name) > 0){
            $initial_contact_name.=str_repeat('&nbsp;',30-strlen($initial_contact_name));
        }
        $final_contact_name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $final_contact_backflow_certification_number = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $final_tested_on = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        if($initial != $final){
            $final_contact_name = $final->contact->name;
            if(30-strlen($final_contact_name) > 0){
                $final_contact_name.=str_repeat('&nbsp;',30-strlen($final_contact_name));
            }
            $final_contact_backflow_certification_number = $final->contact->backflow_certification_number;
            $final_tested_on = date('m-d-Y',strtotime($final->tested_on));
            $final_passed = 'checked="checked"';
        }
        $num_line_length = 6;
        switch($report->backflow_assembly->backflow_type->backflow_super_type->name){
            case 'RP' :
                $rp_reading_1 = sprintf('%04.1f', $initial->reading_1);
                $rp_reading_2 = sprintf('%04.1f',$initial->reading_2);
                if($num_line_length-strlen($rp_reading_1) > 0){
                    $rp_reading_1=str_repeat('&nbsp;',$num_line_length-strlen($rp_reading_1)).$rp_reading_1;
                }
                if($num_line_length-strlen($rp_reading_2) > 0){
                    $rp_reading_2=str_repeat('&nbsp;',$num_line_length-strlen($rp_reading_2)).$rp_reading_2;
                }
                if($initial->passed){
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
                if($initial != $final){
                    $final_1 = sprintf('%04.1f',$final->reading_2);
                    $final_2 = 'OK';
                    $final_3 = sprintf('%04.1f',$final->reading_1);
                    $final_1_closed = 'checked="checked"';
                    $final_2_closed = 'checked="checked"';
                    $final_3_closed = 'checked="checked"';
                }
                break;
            case 'DC' :
                $dc_reading_1 = sprintf('%04.1f',$initial->reading_1);
                $dc_reading_2 = sprintf('%04.1f',$initial->reading_2);
                if($num_line_length-strlen($dc_reading_1) > 0){
                    $dc_reading_1=str_repeat('&nbsp;',$num_line_length-strlen($dc_reading_1)).$dc_reading_1;
                }
                if($num_line_length-strlen($dc_reading_2) > 0){
                    $dc_reading_2=str_repeat('&nbsp;',$num_line_length-strlen($dc_reading_2)).$dc_reading_2;
                }
                if($initial->reading_1 > 1){
                    $dc_1_pass = 'checked="checked"';
                }
                else{
                    $dc_1_fail = 'checked="checked"';
                }
                if($initial->reading_2 > 1){
                    $dc_2_pass = 'checked="checked"';
                }
                else{
                    $dc_2_fail = 'checked="checked"';
                }
                if($initial->passed){
                    $initial_passed = 'checked="checked"';
                }
                else{
                    $initial_failed = 'checked="checked"';
                }
                if($initial != $final){
                    $final_1 = sprintf('%04.1f',$final->reading_1);
                    $final_2 = sprintf('%04.1f',$final->reading_2);
                    $final_1_closed = 'checked="checked"';
                    $final_2_closed = 'checked="checked"';
                }
                break;
            case 'PVB' :
                if($initial->reading_1){
                    $pvb_1_pass = 'checked="checked"';
                }
                else{
                    $pvb_1_fail = 'checked="checked"';
                }
                if($initial->reading_2){
                    $pvb_2_pass = 'checked="checked"';
                }
                else{
                    $pvb_2_fail = 'checked="checked"';
                }
                if($initial->passed){
                    $initial_passed = 'checked="checked"';
                }
                else{
                    $initial_failed = 'checked="checked"';
                }
                $pvb_reading_1 = sprintf('%04.1f',$initial->reading_1);
                $pvb_reading_2 = sprintf('%04.1f',$initial->reading_2);
                if($num_line_length-strlen($pvb_reading_1) > 0){
                    $pvb_reading_1=str_repeat('&nbsp;',$num_line_length-strlen($pvb_reading_1)).$pvb_reading_1;
                }
                if($num_line_length-strlen($pvb_reading_2) > 0){
                    $pvb_reading_2=str_repeat('&nbsp;',$num_line_length-strlen($pvb_reading_2)).$pvb_reading_2;
                }
                if($initial != $final){
                    $pvb_final_1 = sprintf('%04.1f',$final->reading_1);
                    $pvb_final_2 = sprintf('%04.1f',$final->reading_2);
                    $pvb_final_closed = 'checked="checked"';
                    if($num_line_length-strlen($pvb_final_1) > 0){
                        $pvb_final_1=str_repeat('&nbsp;',$num_line_length-strlen($pvb_final_1)).$pvb_final_1;
                    }
                    if($num_line_length-strlen($pvb_final_2) > 0){
                        $pvb_final_2=str_repeat('&nbsp;',$num_line_length-strlen($pvb_final_2)).$pvb_final_2;
                    }
                }
                break;
        }
        if($num_line_length-strlen($final_1) > 0){
            $final_1=str_repeat('&nbsp;',$num_line_length-strlen($final_1)).$final_1;
        }
        if($num_line_length-strlen($final_2) > 0){
            $final_2=str_repeat('&nbsp;',$num_line_length-strlen($final_2)).$final_2;
        }
        if($num_line_length-strlen($final_3) > 0){
            $final_3=str_repeat('&nbsp;',$num_line_length-strlen($final_3)).$final_3;
        }
        $number = "";
        $numbers = $report->backflow_assembly->contact->phoneNumbers;
        if($numbers->first()){
            $number = $numbers->first()->phone_number;
        }
        $html = '
                <div style="text-align:center"><h3>Backflow Assembly Test Report</h3></div>
                <div style="float:left;width:68%;font-size:11px;padding:5px;">
                    <div class="info"><span class="header">Water System:</span> ' . $report->backflow_assembly->backflow_water_system->name . '</div>
                    <div class="info"><span class="header">Owner:</span> ' . $property->client->name . '</div>
                    <div class="info"><span class="header">Contact Person:</span> ' . $report->backflow_assembly->contact->name . '&nbsp;&nbsp;&nbsp;<span class="header">Phone:</span> ' . $number . '</div>
                    <div class="info"><span class="header">Address:</span> ' . $billing_property->address1 . ' ' . $billing_property->address_2 . '&nbsp;&nbsp;&nbsp;<span class="header">City:</span> ' . $billing_property->city . '&nbsp;&nbsp;&nbsp;<span class="header">State:</span> ' . $billing_property->state . '&nbsp;&nbsp;&nbsp;<span class="header">Zip:</span> ' . $billing_property->zip . '</div>
                    <br />
                    <div class="info"><span class="header">Assembly Location:</span> ' . $property->name . '</div>
                    <div class="info"><span class="header">Address:</span> ' . $report->backflow_assembly->property->address1 . ' ' . $report->backflow_assembly->property->address_2 . '&nbsp;&nbsp;&nbsp;<span class="header">City:</span> ' . $report->backflow_assembly->property->city . '&nbsp;&nbsp;&nbsp;<span class="header">State:</span> ' . $report->backflow_assembly->property->state . '&nbsp;&nbsp;&nbsp;<span class="header">Zip:</span> ' . $report->backflow_assembly->property->zip . '</div>
                    <br />
                    <div class="info"><span class="header">Assembly Placement:</span> ' . $report->backflow_assembly->placement . '&nbsp;&nbsp;&nbsp;<span class="header">Use:</span> ' . $report->backflow_assembly->use . '</div>
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
                    ' . $final->contact->name  . '<br />
                    CERTIFICATION # '.$final->contact->backflow_certification_number.'<br />
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
                            PSI Across <span class="underline">' . $rp_reading_2 . '</span>#<br />
                            Closed tight <input type="checkbox" '.$rp_1_pass.'><br />
                            Leaked <input type="checkbox" '.$rp_1_fail.' />
                        </td>
                        <td>
                            PSI Across <span class="underline">'.$rp_2_value.'</span>#<br />
                            Closed tight <input type="checkbox" '.$rp_2_pass.'><br />
                            Leaked <input type="checkbox" '.$rp_2_fail.'>
                        </td>
                        <td>
                            Opened At <span class="underline">'.$rp_reading_1.'</span>#<br />
                            Opened Under 2# <input type="checkbox" '.$rp_3_pass.'><br />
                            or did not open <input type="checkbox" '.$rp_3_fail.'>
                        </td>
                        <td>
                            AIR INLET:<br />
                            Opened at <span class="underline">' . $pvb_reading_1 . '</span>#<br />
                            Opened Under 1# <input type="checkbox" ' . $pvb_1_pass . '><br />
                            or did not open <input type="checkbox" ' . $pvb_1_fail . '>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            DC
                        </td>
                        <td>
                            Held at <span class="underline">' . $dc_reading_1 . '</span>#<br />
                            Closed tight <input type="checkbox" ' . $dc_1_pass . '><br />
                            Leaked <input type="checkbox" ' . $dc_1_fail . '>
                        </td>
                        <td>
                            Held at <span class="underline">' . $dc_reading_2 . '</span>#<br />
                            Closed tight <input type="checkbox" ' . $dc_2_pass . '><br />
                            Leaked <input type="checkbox" ' . $dc_2_fail . '>
                        </td>
                        <td>
                        </td>
                        <td>
                            CHECK VALVE:<span class="underline">' . $pvb_reading_2 . '</span>#<br />
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
                            PSI Across <span class="underline">' . $final_1 . '</span>#<br />
                            Closed Tight <input type="checkbox" ' . $final_1_closed . '><br />
                        </td>
                        <td>
                            PSI Across <span class="underline">' . $final_2 . '</span>#<br />
                            Closed Tight <input type="checkbox" ' . $final_1_closed . '><br />
                        </td>
                        <td>
                            Opened at <span class="underline">' . $final_3 . '</span>#<br />
                            Reduced Pressure <input type="checkbox" ' . $final_1_closed . '><br />
                        </td>
                        <td>
                            INLET Opened At <span class="underline">' . $pvb_final_1 . '</span>#<br />
                            CHECK VALVE: <span class="underline">' . $pvb_final_2 . '</span>#<br />
                            Closed tight <input type="checkbox" ' . $pvb_final_closed . '><br />
                        </td>
                    </tr>
                </table>
                <table class="plain" style="font-size:12pt;width:100%;">
                    <tr><td class="header">Initial Test By:</td><td style="text-align:left;text-decoration:underline;">' . $initial_contact_name  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . $initial->contact->backflow_certification_number  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . date('m-d-Y',strtotime($initial->tested_on))  . '</td></tr>
                    <tr><td class="header">Repaired By:</td><td style="text-align:left;text-decoration:underline;">' . $final_contact_name  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . $final_contact_backflow_certification_number  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . $final_tested_on  . '</td></tr>
                    <tr><td class="header">Final Test By:</td><td style="text-align:left;text-decoration:underline;">' . $final_contact_name  . '</td><td class="header">Certification No.</td><td style="text-align:left;text-decoration:underline;">' . $final_contact_backflow_certification_number  . '</td><td class="header">Date:</td><td style="text-align:left;text-decoration:underline;">' . $final_tested_on  . '</td></tr>
                </table>
                <br />
                <div class="info">This assembly\'s <span class="header">INITIAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" '.$initial_passed.'/> <span class="header">Unsatisfactory</span> <input type="checkbox" '.$initial_failed.'/></div>
                <div class="info">This assembly\'s <span class="header">FINAL TEST</span> performance was: <span class="header">Satisfactory</span> <input type="checkbox" '.$final_passed.' /> <span class="header">Unsatisfactory</span><input type="checkbox" /></div>
                <div class="info">I certify the above test has been performed and I am aware of the final performance.</div>
                <div class="info">BY: ________________________________________ Assembly Owner Representative Assembly</div>
        ';
        return $html;
    }
    
    public function pdf($id, Request $request)
    {
        class_alias('Illuminate\Support\Facades\Config', 'Config');//needed for PDF stuff to work, but conflicts with phpunit
        $html = $this->html($id, $request);
        $pdf = Pdf::loadHtml($html);
        $report = BackflowTestReport::with('backflow_assembly','backflow_assembly.property','backflow_assembly.backflow_water_system')->findOrFail($id);
        $filename = $report->backflow_assembly->property->name . '-' . $report->backflow_assembly->backflow_water_system->name;
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
        $pdf = Pdf::loadHtml($html);
        $ids = $request->input('backflow_test_report_id');
        $report = BackflowTestReport::with('backflow_assembly','backflow_assembly.property')->findOrFail($ids[0]);
        $filename = $report->backflow_assembly->property->name;
        return $pdf->stream($filename . '.pdf');
    }
    
    protected $model_validation = [
       'backflow_assembly_id' => 'integer|exists:backflow_assemblies,id',
       'visual_inspection_notes' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
       'backflow_installed_to_code' => 'boolean',
       'report_date' => 'date',
       'submitted_date' => 'date'
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