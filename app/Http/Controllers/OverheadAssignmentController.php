<?php

namespace App\Http\Controllers;

use App\OverheadAssignment;
use Illuminate\Http\Request;

class OverheadAssignmentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = OverheadAssignment::whereNull('parent_id')->with('children')->with('children.children')->with('children.children.children')->with('children.children.children.children');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = OverheadAssignment::create($values);
        return response(['data' => $item], 201, ['Location' => route('overhead_assignment.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = OverheadAssignment::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = OverheadAssignment::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = OverheadAssignment::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'integer|nullable',
       'parent_id' => 'integer',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
}