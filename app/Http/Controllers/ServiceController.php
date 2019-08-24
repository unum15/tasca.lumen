<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = Service::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Service::create($values);
        return response(['data' => $item], 201, ['Location' => route('service.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Service::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Service::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Service::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'vehicle_id' => 'integer|exists:vehicles,id',
       'service_type_id' => 'integer|exists:service_types,id',
       'description' => 'string|max:1073741824',
       'quantity' => 'integer',
       'usage_type_id' => 'integer|exists:usage_types,id',
       'usage_interval' => 'integer',
       'part_number' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
       'time_interval' => 'string|max:64:nullable',
    ];
    
    protected $model_validation_required = [
       'vehicle_id' => 'required',
       'service_type_id' => 'required',
       'description' => 'required',
       'quantity' => 'required',
       'usage_type_id' => 'required',
       'usage_interval' => 'required',
    ];

    protected $model_includes = [
       'usage_type',
       'service_type',
       'vehicle'
    ];
    
}