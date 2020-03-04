<?php

namespace App\Http\Controllers;

use App\Fueling;
use Illuminate\Http\Request;

class FuelingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = Fueling::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Fueling::create($values);
        return response(['data' => $item], 201, ['Location' => route('fueling.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Fueling::with($includes)->findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Fueling::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Fueling::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'vehicle_id' => 'integer|exists:vehicles,id',
       'beginning_reading' => 'integer|nullable',
       'ending_reading' => 'integer|nullable',
       'date' => 'date|nullable',
       'gallons' => 'numeric|nullable',
       'amount' => 'numeric|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'vehicle_id' => 'required',
    ];

    protected $model_includes = [
       'vehicle'
    ];
    
}