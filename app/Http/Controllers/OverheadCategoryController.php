<?php

namespace App\Http\Controllers;

use App\OverheadCategory;
use Illuminate\Http\Request;

class OverheadCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = OverheadCategory::whereNull('parent_id')->with('overhead_assignments')->with('children')->with('children.children')->with('children.children.children')->with('children.children.children.children');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = OverheadCategory::create($values);
        return response(['data' => $item], 201, ['Location' => route('overhead_category.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = OverheadCategory::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = OverheadCategory::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = OverheadCategory::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'integer|nullable',
       'parent_id' => 'integer|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
}