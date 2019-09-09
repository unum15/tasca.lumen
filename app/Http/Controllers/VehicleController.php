<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = Vehicle::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Vehicle::create($values);
        return response(['data' => $item], 201, ['Location' => route('vehicle.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Vehicle::with($includes)->findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Vehicle::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Vehicle::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'vehicle_type_id' => 'integer|exists:vehicle_types,id',
       'year' => 'integer|nullable',
       'make' => 'string|max:1020|nullable',
       'model' => 'string|max:1020|nullable',
       'trim' => 'string|max:1020|nullable',
       'vin' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'vehicle_type_id' => 'required',
    ];

    protected $model_includes = [
       'vehicle_type'
    ];
    
}