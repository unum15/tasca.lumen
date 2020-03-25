<?php

namespace App\Http\Controllers;

use App\PropertyUnit;
use Illuminate\Http\Request;

class PropertyUnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = PropertyUnit::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = PropertyUnit::create($values);
        return response(['data' => $item], 201, ['Location' => route('property_unit.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = PropertyUnit::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = PropertyUnit::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = PropertyUnit::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'property_id' => 'integer|exists:properties,id',
       'name' => 'string|max:1020',
       'number' => 'string|max:1020|nullable',
       'phone' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'property_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'property'
    ];
    
}