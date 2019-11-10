<?php

namespace App\Http\Controllers;

use App\BackflowStyleValve;
use Illuminate\Http\Request;

class BackflowStyleValveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $query = BackflowStyleValve::with($includes)->orderBy('id');
        foreach($values as $field => $value){
            $query->where($field, $value);
        }
        $items = $query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowStyleValve::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_style_valve.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowStyleValve::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowStyleValve::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowStyleValve::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_style_id' => 'integer|exists:backflow_styles,id',
       'name' => 'string|max:1020',
       'test_name' => 'string|max:1020',
       'success_label' => 'string|max:1020',
       'fail_label' => 'string|max:1020',
    ];
    
    protected $model_validation_required = [
       'backflow_style_id' => 'required',
       'name' => 'required',
       'test_name' => 'required',
       'success_label' => 'required',
       'fail_label' => 'required',
    ];

    protected $model_includes = [
       'backflow_style',
       'backflow_valve_parts'
    ];
    
}