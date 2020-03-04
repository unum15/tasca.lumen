<?php

namespace App\Http\Controllers;

use App\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = Repair::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Repair::create($values);
        return response(['data' => $item], 201, ['Location' => route('repair.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Repair::with($includes)->findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Repair::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Repair::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'vehicle_id' => 'integer|exists:vehicles,id',
       'repair' => 'string|max:1020',
       'ending_reading' => 'integer|nullable',
       'date' => 'date|nullable',
       'amount' => 'numeric|nullable',
       'where' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'vehicle_id' => 'required',
       'repair' => 'required',
    ];

    protected $model_includes = [
       'vehicle'
    ];
    
}