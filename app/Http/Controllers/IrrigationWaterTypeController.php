<?php

namespace App\Http\Controllers;

use App\IrrigationWaterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationWaterTypeController extends Controller
{
    public function __construct()
    {
        Log::debug('IrrigationWaterTypeController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationWaterType::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationWaterType::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_water_type.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationWaterType::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationWaterType::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationWaterType::findOrFail($id);
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