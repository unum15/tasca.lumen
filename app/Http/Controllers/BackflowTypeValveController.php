<?php

namespace App\Http\Controllers;

use App\BackflowTypeValve;
use Illuminate\Http\Request;

class BackflowTypeValveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowTypeValve::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowTypeValve::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_type_valf.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowTypeValve::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTypeValve::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTypeValve::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_type_id' => 'integer|exists:backflow_types,id',
       'name' => 'string|max:1020',
       'test_name' => 'string|max:1020',
       'success_label' => 'string|max:1020',
       'fail_label' => 'string|max:1020',
    ];
    
    protected $model_validation_required = [
       'backflow_type_id' => 'required',
       'name' => 'required',
       'test_name' => 'required',
       'success_label' => 'required',
       'fail_label' => 'required',
    ];

    protected $model_includes = [
       'backflow_type'
    ];
    
}