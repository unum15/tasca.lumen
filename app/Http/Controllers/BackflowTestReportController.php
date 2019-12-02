<?php

namespace App\Http\Controllers;

use App\BackflowTestReport;
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

    public function delete(Request $request, $id)
    {
        $item = BackflowTestReport::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    public function pdf($id, Request $request)
    {
    $report = BackflowTestReport::with('backflow_tests','backflow_assembly','backflow_assembly.property','backflow_assembly.property.client','backflow_assembly.backflow_water_system')->find($id);
    $billing_property = $report->backflow_assembly->property->client->billingProperty;
    if(!$billing_property){
        $billing_property = $report->backflow_assembly->property;
    }
    $property = $report->backflow_assembly->property;
    $initial = $report->backflow_tests->first();
    $final = $report->backflow_tests->last();
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
            </style>
        <head>
        <body>
            <div style="text-align:center"><h3>Backflow Assembly Test Report</h3></div>
            <div style="border: 1px solid black;float:left;width:70%;">
                Water System: ' . $report->backflow_assembly->backflow_water_system->name . '<br />
                Owner: ' . $property->client->name . '<br />
                Contact Person: ' . $report->backflow_assembly->contact->name . ' Phone: ' . $billing_property->phone_number . '<br />
                Address: ' . $billing_property->address_1 . ' ' . $billing_property->address_2 . ' City: ' . $billing_property->city . ' State: ' . $billing_property->state . ' Zip: ' . $billing_property->zip . '<br />
                Assembly Location: ' . $property->name . '<br />
                Address: ' . $billing_property->address_1 . ' ' . $billing_property->address_2 . ' City: ' . $billing_property->city . ' State: ' . $billing_property->state . ' Zip: ' . $billing_property->zip . '<br />
                Assembly Placement: ' . $report->backflow_assembly->placement . ' Use: ' . $report->backflow_assembly->use . '<br />
                Assembly Style: ' . $report->backflow_assembly->backflow_type->name . '<br />
                Size: ' . $report->backflow_assembly->backflow_size->name . '" Model: ' . $report->backflow_assembly->backflow_model->name . ' Serial No.: ' . $report->backflow_assembly->serial_number . '<br />
                Proper installation and use: ' . ($report->backflow_installed_to_code ? 'To Code' : 'Not To Code') . '<br />
                Visual inspection notes: ' . $report->visual_inspection_notes . ' <br />
            </div>
            <div style="border: 1px solid black;float:right;width:29%;text-align:center;font-size: 8pt;">
                <img src="/images/w_logo.jpg" style="width:100%;" />
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
                        Cleaned: <input type="checkbox"><br />
                        Replaced:<br />
                        Disc <input type="checkbox"><br />
                        Spring <input type="checkbox"><br />
                        Guide <input type="checkbox"><br />
                        Pin Feather <input type="checkbox"><br />
                        Hinge pin <input type="checkbox"><br />
                        Seat <input type="checkbox"><br />
                        Diaphragm <input type="checkbox"><br />
                        Other (describe)<input type="checkbox"><br />
                    </td>
                    <td>
                        Cleaned: <input type="checkbox"><br />
                        Replaced:<br />
                        &nbsp;Disc <input type="checkbox"><br />
                        &nbsp;Spring <input type="checkbox"><br />
                        &nbsp;Guide <input type="checkbox"><br />
                        &nbsp;Pin Feather <input type="checkbox"><br />
                        &nbsp;Hinge pin <input type="checkbox"><br />
                        &nbsp;Seat <input type="checkbox"><br />
                        &nbsp;Diaphragm <input type="checkbox"><br />
                        &nbsp;Other (describe)<input type="checkbox"><br />
                    </td>
                    <td>
                        Cleaned: <input type="checkbox"><br />
                        Replaced:<br />
                        &nbsp;Disc <input type="checkbox"><br />
                        &nbsp;Spring <input type="checkbox"><br />
                        &nbsp;Diaphragm <input type="checkbox"><br />
                        <br />
                        &nbsp;Seat(s) <input type="checkbox"><br />
                        &nbsp;O-ring(s) <input type="checkbox"><br />
                        &nbsp;Module <input type="checkbox"><br />
                        <br />
                        &nbsp;Other (describe) <input type="checkbox"><br />
                    </td>
                    <td>
                        Cleaned: <input type="checkbox"><br />
                        Replaced:<br />
                        &nbsp;Air Inlet Disc <input type="checkbox"><br />
                        &nbsp;Air Inlet Spring <input type="checkbox"><br />
                        &nbsp;Check Disc <input type="checkbox"><br />
                        &nbsp;Check Spring <input type="checkbox"><br />
                        &nbsp;Other (describe) <input type="checkbox"><br />
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
            Initial Test By: ' . $initial->contact->name  . ' Certification No. ADDTODATABASE Date: ' . $final->tested_on  . '<br />
            Repaired By: ' . $final->contact->name  . ' Certification No. ADDTODATABASE Date: ' . $final->tested_on  . '<br />
            Final Test By: ' . $final->contact->name  . ' Certification No. ADDTODATABASE Date: ' . $final->tested_on  . '<br />
            This assembly\'s INITIAL TEST performance was: Satisfactory <input type="checkbox" '.$initial_passed.'/> Unsatisfactory <input type="checkbox" '.$initial_failed.'/><br />
            This assembly\'s FINAL TEST performance was: Satisfactory <input type="checkbox" checked="checked" /> Unsatisfactory<input type="checkbox" /><br />
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
    ];
    
    protected $model_validation_required = [
       'backflow_assembly_id' => 'required',
       'backflow_installed_to_code' => 'required',
    ];

    protected $model_includes = [
       'backflow_assembly',
       'backflow_assembly.property',
       'backflow_assembly.property.client',
       'backflow_assembly.backflow_type',
       'backflow_tests'
    ];
    
}