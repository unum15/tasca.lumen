<?php

namespace App\Http\Controllers;

use App\IrrigationControllerLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationControllerLocationController extends Controller
{
    public function __construct()
    {
        Log::debug('IrrigationControllerLocationController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationControllerLocation::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationControllerLocation::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_controller_location.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationControllerLocation::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationControllerLocation::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationControllerLocation::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
}