<?php

namespace App\Http\Controllers;

use App\BackflowModel;
use Illuminate\Http\Request;

class BackflowModelController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowModel::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowModel::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_model.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowModel::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowModel::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        if(isset($values['sizes'])){
            $item->backflow_sizes()->attach($values['sizes']);
        }
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowModel::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_manufacturer_id' => 'integer|exists:backflow_manufacturers,id',
       'backflow_type_id' => 'integer|exists:backflow_types,id',
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'integer|nullable',
       'sizes' => 'array'
    ];
    
    protected $model_validation_required = [
       'backflow_manufacturer_id' => 'required',
       'backflow_type_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'backflow_manufacturer',
       'backflow_type',
       'backflow_sizes'
    ];
    
}