<?php

namespace App\Http\Controllers;

use App\LaborActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaborActivityController extends Controller
{
    public function __construct()
    {
        Log::debug('LaborActivityController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = LaborActivity::whereNull('parent_id')
            ->with('labor_assignments')
            ->with('children')
            ->with('children.labor_assignments')
            ->with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = LaborActivity::create($values);
        return response(['data' => $item], 201, ['Location' => route('labor_activity.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = LaborActivity::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = LaborActivity::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = LaborActivity::findOrFail($id);
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