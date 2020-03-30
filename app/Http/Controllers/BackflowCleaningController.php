<?php

namespace App\Http\Controllers;

use App\BackflowCleaning;
use Illuminate\Http\Request;

class BackflowCleaningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowCleaning::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->orderBy('id')->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowCleaning::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_cleaning.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowCleaning::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowCleaning::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowCleaning::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_test_report_id' => 'integer|exists:backflow_test_reports,id',
       'contact_id' => 'integer|exists:contacts,id',
       'backflow_valve_id' => 'integer|exists:backflow_valves,id',
       'backflow_valve_part_id' => 'integer|exists:backflow_valve_parts,id',
       'cleaned_on' => 'date',
    ];
    
    protected $model_validation_required = [
       'backflow_test_report_id' => 'required',
       'contact_id' => 'required',
       'backflow_valve_id' => 'required',
       'backflow_valve_part_id' => 'required',
       'cleaned_on' => 'required',
    ];

    protected $model_includes = [
       'backflow_valve_part',
       'backflow_valf',
       'contact',
       'backflow_test_report'
    ];
    
}