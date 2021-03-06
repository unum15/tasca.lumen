<?php

namespace App\Http\Controllers;

use App\IrrigationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationControllerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationController::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationController::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_controller.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationController::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationController::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationController::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'irrigation_system_id' => 'integer|exists:irrigation_systems,id',
       'name' => 'string|max:1020',
       'placement' => 'string|max:1020|nullable',
       'irrigation_controller_location_id' => 'integer|exists:irrigation_controller_locations,id',
       'model' => 'string|max:1020|nullable',
       'zones' => 'integer|nullable',
       'property_unit_id' => 'integer|exists:property_units,id|nullable',
       'username' => 'string|max:1020|nullable',
       'password' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
       'accessible' => 'boolean|nullable',
    ];
    
    protected $model_validation_required = [
       'irrigation_system_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'irrigation_system',
       'irrigation_controller_others',
       'irrigation_zones'
    ];
    
}