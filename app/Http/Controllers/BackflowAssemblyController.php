<?php

namespace App\Http\Controllers;

use App\BackflowAssembly;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BackflowAssemblyController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowAssembly::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $recent_reports = $request->input('recent_reports');
        if($recent_reports){
            $recent_report_date = date_create();
            $recent_report_date->modify("-$recent_reports days");
            //echo $recent_report_date->format('Y-m-d');
            $items_query->with(['backflow_test_reports' => function ($query) use ($recent_report_date) {
                $query->where('report_date', '>=', $recent_report_date);
            }],'backflow_test_reports.backflow_tests','backflow_test_reports.backflow_repairs','backflow_test_reports.backflow_cleanings');
            //$items_query->with([]);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowAssembly::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_assembly.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowAssembly::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowAssembly::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowAssembly::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    public function tagHTML($id)
    {
        $backflow_assembly = BackflowAssembly::findOrFail($id);
        $year_table = '';
        $current_year = date('Y');
        for($year=$current_year;$year<$current_year+5;$year++){
            $year_table .= '
                <tr>
                    <td>
                        ' . $year . '
                    </td>
            ';
            for($month = 0; $month < 12; $month++){
                $year_table .= '
                        <td>
                            T
                        </td>
                        <td>
                            R
                        </td>
                ';
            }
            $year_table .= '
                </tr>';
        }
        $src = '/api/images/w_logo.jpg';
        if(env('APP_ENV')=='local'){
            $src = '/images/w_logo.jpg';
        }
        $html = '
        <div style="border:1px solid black;padding-bottom:7px;padding-top:7px;">
            <div style="width:51%;float:left;position:relative;border-right:1px solid black;">
                This assembly is tested annually by<br />
                <img src="' . $src . '" style="width:40%;float:left;margin-right:10px;margin-bottom:20px;" />Waters Contracting<br />
                801-546-0844<br />
                License # 17193<br />
                License # 96005<br />
                Level II Backflow Technicians<br />
                <div style="text-align:center;">This is a record of this device testing history</div>
                <div style="font-size:150%;text-align:center;font-weight:bold;">DO NOT REMOVE THIS TAG</div>
                <table style="font-size:6pt;text-align:center;">
                    <tr>
                        <td>YEAR</td>
                        <td colspan="2">J</td>
                        <td colspan="2">F</td>
                        <td colspan="2">M</td>
                        <td colspan="2">A</td>
                        <td colspan="2">M</td>
                        <td colspan="2">J</td>
                        <td colspan="2">J</td>
                        <td colspan="2">A</td>
                        <td colspan="2">S</td>
                        <td colspan="2">O</td>
                        <td colspan="2">N</td>
                        <td colspan="2">D</td>
                    </tr>
                    ' . $year_table . '
                </table>
            </div>
            <div style="width:48%;float:right;position:relative;">
                If this assembly needs attention call the number on<br />
                the other side with the following information.<br />
                <span style="font-weight:bold;">Owner</span> ' . $backflow_assembly->property->client->name . '<br />
                <span style="font-weight:bold;">Location</span> ' . $backflow_assembly->property->name . '<br />
                <span style="font-weight:bold;">Address</span> ' . $backflow_assembly->property->address1 . ' ' . $backflow_assembly->property->address2 . ' ' . ($backflow_assembly->property_unit ? $backflow_assembly->property_unit->name : null)  . '<br />
                ' .  $backflow_assembly->property->city . ',' . $backflow_assembly->property->state . ' ' . $backflow_assembly->property->zip . '<br />
                <span style="font-weight:bold;">Placement</span> ' . $backflow_assembly->placement . '<br />
                <span style="font-weight:bold;">Use</span> ' . $backflow_assembly->use . '<br />
                <span style="font-weight:bold;">Type of Assembly</span> ' . $backflow_assembly->backflow_type->name . ' Size ' . $backflow_assembly->backflow_size->name . '"<br />
                <span style="font-weight:bold;">Manufacturer</span> ' . $backflow_assembly->backflow_manufacturer->name . ' Model ' . $backflow_assembly->backflow_model->name . '<br />
                <span style="font-weight:bold;">Serial No</span> ' . $backflow_assembly->serial_number . '<br />
            </div>
        </div>
';
        return $html;
    }
    
    public function tagsPdf(Request $request)
    {
        class_alias('Illuminate\Support\Facades\Config', 'Config');//needed for PDF stuff to work, but conflicts with phpunit
        $ids = $request->input('backflow_assembly_id');
        
        $html = '<!DOCTYPE html>
    <head>
    </head>
    <body style="font-size:10pt">
';
        $tags_on_page = 0;
        foreach($ids as $id){
            $html .= $this->tagHtml($id);
            $tags_on_page ++;
            if($tags_on_page == 4){
                
            }
        }
        $html .='
    </body>
</html>';
        $pdf = Pdf::loadHtml($html);
        $backflow_assembly = BackflowAssembly::findOrFail($id);
        $filename = $backflow_assembly->property->name . '-' . $backflow_assembly->backflow_water_system->name . '-' .$backflow_assembly->use;
        return $pdf->stream($filename . '.pdf');
    }
    
    public function unique($field)
    {
        if(!in_array($field,array_keys($this->model_validation))){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'field' => ['Field is not a valid field for Backflow Assembly'],
            ]);
            throw $error;
        }
        $items = BackflowAssembly::whereNotNull($field)->distinct()->get($field);
        return ['data' => $items];
    }
    
    protected $model_validation = [
       'property_id' => 'integer|exists:properties,id',
       'property_unit_id' => 'integer|exists:property_units,id|nullable',
       'contact_id' => 'integer|exists:contacts,id|nullable',
       'backflow_type_id' => 'integer|nullable|exists:backflow_types,id',
       'backflow_water_system_id' => 'integer|nullable|exists:backflow_water_systems,id',
       'backflow_size_id' => 'integer|nullable|exists:backflow_sizes,id',
       'backflow_manufacturer_id' => 'integer|nullable|exists:backflow_manufacturers,id',
       'backflow_model_id' => 'integer|nullable|exists:backflow_models,id',
       'active' => 'boolean',
       'month' => 'integer|nullable',
       'use' => 'string|max:4096|nullable',
       'placement' => 'string|max:4096|nullable',
       'gps' => 'string|max:4096|nullable',
       'serial_number' => 'string|max:512|nullable',
       'notes' => 'string|max:4096|nullable',
    ];
    
    protected $model_validation_required = [
       'property_id' => 'required'
    ];

    protected $model_includes = [
       'backflow_model',
       'backflow_manufacturer',
       'backflow_size',
       'backflow_water_system',
       'backflow_type',
       'contact',
       'property',
       'backflow_type.backflow_super_type',
       'backflow_type.backflow_super_type.backflow_valves',
       'backflow_test_reports',
       'backflow_test_reports.backflow_tests',
       'backflow_test_reports.backflow_tests.contact',
       'backflow_test_reports.backflow_repairs',
       'backflow_test_reports.backflow_repairs.backflow_valve_part'
    ];
    
}