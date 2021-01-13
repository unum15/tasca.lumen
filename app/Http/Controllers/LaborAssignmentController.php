<?php

namespace App\Http\Controllers;

use App\LaborAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaborAssignmentController extends Controller
{
    public function __construct()
    {
        Log::debug('LaborAssignmentController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = LaborAssignment::whereNull('parent_id')
            ->with('labor_activities')
            ->with('children')
            ->with('children.labor_activities')
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
        $item = LaborAssignment::create($values);
        return response(['data' => $item], 201, ['Location' => route('labor_assignment.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = LaborAssignment::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = LaborAssignment::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = LaborAssignment::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'integer|nullable',
       'parent_id' => 'integer|nullable',
       'order_id' => 'integer|nullable|exists:orders,id',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];

    protected $model_includes = [
       'order'
    ];
    
}