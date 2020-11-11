<?php

namespace App\Http\Controllers;

use App\IrrigationZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationZoneController extends Controller
{
    public function __construct()
    {
        Log::debug('IrrigationZoneController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationZone::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items_query->orderBy('number');
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationZone::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_zone.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationZone::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationZone::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationZone::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'irrigation_controller_id' => 'integer|exists:irrigation_controllers,id',
       'number' => 'integer',
       'name' => 'string|max:1020|nullable',
       'plant_type' => 'string|max:1020|nullable',
       'head_type' => 'string|max:1020|nullable',
       'gallons_per_minute' => 'numeric|nullable',
       'application_rate' => 'numeric|nullable',
       'heads' => 'integer|nullable',
    ];
    
    protected $model_validation_required = [
       'irrigation_controller_id' => 'required',
       'number' => 'required',
    ];

    protected $model_includes = [
       'irrigation_controller'
    ];
    
}