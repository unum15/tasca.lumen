<?php

namespace App\Http\Controllers;

use App\IrrigationSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationSystemController extends Controller
{
    public function __construct()
    {
        Log::debug('IrrigationSystemController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationSystem::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationSystem::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_system.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationSystem::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationSystem::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationSystem::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'property_id' => 'integer',
       'name' => 'string|max:1020',
       'point_of_connection_location' => 'string|max:1020|nullable',
       'irrigation_water_type_id' => 'integer|nullable|exists:irrigation_water_types,id',
       'backflow_assembly_id' => 'integer|nullable|exists:backflow_assemblies,id',
       'filter_model' => 'string|max:1020|nullable',
       'filter_location' => 'string|max:1020|nullable',
       'property_unit_id' => 'integer|nullable|exists:property_units,id',
       'notes' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'property_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'property_unit',
       'backflow_assembly',
       'irrigation_water_type',
       'irrigation_controllers'
    ];
    
}