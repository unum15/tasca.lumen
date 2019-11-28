<?php

namespace App\Http\Controllers;

use App\BackflowAssembly;
use Illuminate\Http\Request;

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
       'contact_id' => 'integer|exists:contacts,id',
       'backflow_type_id' => 'integer|nullable|exists:backflow_types,id',
       'backflow_water_system_id' => 'integer|nullable|exists:backflow_water_systems,id',
       'backflow_size_id' => 'integer|nullable|exists:backflow_sizes,id',
       'backflow_manufacturer_id' => 'integer|nullable|exists:backflow_manufacturers,id',
       'backflow_model_id' => 'integer|nullable|exists:backflow_models,id',
       'use' => 'string|max:4096|nullable',
       'placement' => 'string|max:4096|nullable',
       'serial_number' => 'string|max:512|nullable',
       'notes' => 'string|max:4096|nullable',
    ];
    
    protected $model_validation_required = [
       'property_id' => 'required',
       'contact_id' => 'required',
    ];

    protected $model_includes = [
       'backflow_model',
       'backflow_manufacturer',
       'backflow_size',
       'backflow_water_system',
       'backflow_type',
       'contact',
       'property'
    ];
    
}