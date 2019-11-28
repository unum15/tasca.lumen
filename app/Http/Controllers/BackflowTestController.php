<?php

namespace App\Http\Controllers;

use App\BackflowTest;
use Illuminate\Http\Request;

class BackflowTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowTest::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowTest::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_test.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowTest::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTest::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTest::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_test_report_id' => 'integer',
       'backflow_valve_id' => 'integer',
       'passed' => 'boolean',
       'pressure' => 'integer',
    ];
    
    protected $model_validation_required = [
       'backflow_test_report_id' => 'required',
       'backflow_valve_id' => 'required',
       'passed' => 'required',
       'pressure' => 'required',
    ];
}