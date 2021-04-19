<?php

namespace App\Http\Controllers;

use App\BackflowWaterSystem;
use Illuminate\Http\Request;

class BackflowWaterSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowWaterSystem::with($includes)->orderBy('name')->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowWaterSystem::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_water_system.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowWaterSystem::with($includes)->findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowWaterSystem::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowWaterSystem::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
        'name' => 'string|max:1020',
        'address' => 'string|max:1020|nullable',
        'city' => 'string|max:1020|nullable',
        'state' => 'string|max:2|nullable',
        'zip' => 'string|max:16|nullable',
        'phone' => 'string|max:16|nullable',
        'contact' =>  'string|max:1020|nullable',
        'email' =>  'string|max:1020|nullable',
        'notes' => 'string|max:1073741824|nullable',
        'sort_order' => 'integer|nullable|nullable',
        'abbreviation' =>  'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
}