<?php

namespace App\Http\Controllers;

use App\BackflowAssembly;
use Illuminate\Http\Request;

class BackflowAssemblyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowAssembly::with($includes)->get();
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
        $item = BackflowAssembly::find($id)->with($includes)->firstOrFail();
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
    
    protected $model_validation = [
       'property_id' => 'integer|exists:properties,id',
       'contact_id' => 'integer|exists:contacts,id',
       'backflow_type_id' => 'integer|nullable|exists:backflow_types,id',
       'backflow_water_system_id' => 'integer|nullable|exists:backflow_water_systems,id',
       'backflow_use_id' => 'integer|nullable|exists:backflow_uses,id',
       'backflow_manufacturer_id' => 'integer|nullable|exists:backflow_manufacturers,id',
       'backflow_model_id' => 'integer|nullable|exists:backflow_model,id',
       'placement' => 'string|max:4096|nullable',
       'size' => 'string|max:128|nullable',
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
       'backflow_us',
       'backflow_water_system',
       'backflow_type',
       'contact',
       'property'
    ];
    
}