<?php

namespace App\Http\Controllers;

use App\IrrigationControllerOther;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationControllerOtherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = IrrigationControllerOther::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = IrrigationControllerOther::create($values);
        return response(['data' => $item], 201, ['Location' => route('irrigation_controller_other.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = IrrigationControllerOther::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = IrrigationControllerOther::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = IrrigationControllerOther::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'irrigation_controller_id' => 'integer|exists:irrigation_controllers,id',
       'name' => 'string|max:1020',
       'value' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'irrigation_controller_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'irrigation_controller'
    ];
    
}