<?php

namespace App\Http\Controllers;

use App\BackflowValve;
use Illuminate\Http\Request;

class BackflowValveController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowValve::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $type = $request->input('backflow_type_id');
        if($type){
            $items_query->whereHas('backflow_types', function ($query) use ($type){
                $query->where('backflow_types.id',$type);
            });
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowValve::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_valve.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowValve::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowValve::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowValve::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'test_label' => 'string|max:1020',
       'test_value' => 'string|max:1020',
       'success_label' => 'string|max:1020',
       'fail_label' => 'string|max:1020',
       'store_value' => 'boolean'
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'test_label' => 'required',
       'test_value' => 'required',
       'success_label' => 'required',
       'fail_label' => 'required',
       'store_value' => 'required',
    ];
    
    protected $model_includes = [
       'backflow_valve_parts'
    ];
}