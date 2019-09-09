<?php

namespace App\Http\Controllers;

use App\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = Maintenance::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Maintenance::create($values);
        return response(['data' => $item], 201, ['Location' => route('maintenance.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Maintenance::with($includes)->findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Maintenance::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Maintenance::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'service_id' => 'integer|exists:services,id',
       'ending_reading' => 'integer|nullable',
       'date' => 'date|nullable',
       'amount' => 'numeric|nullable',
       'where' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'service_id' => 'required',
    ];

    protected $model_includes = [
       'service'
    ];
    
}