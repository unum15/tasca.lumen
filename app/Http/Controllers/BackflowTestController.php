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
        $items = $items_query->orderBy('id')->get();
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
        if(isset($values['reading_2'])){
            $values['reading_2'] = $values['reading_2'] != '' ? $values['reading_2'] : NULL;//fix with middleware \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        }
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTest::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'backflow_test_report_id' => 'integer|exists:backflow_test_reports,id',
       'contact_id' => 'integer|exists:contacts,id',
       'reading_1' => 'numeric|nullable',
       'reading_2' => 'numeric|nullable',
       'tested_on' => 'date',
       'passed' => 'boolean|nullable',
       'notes' => 'string|max:1020|nullable'
    ];
    
    protected $model_validation_required = [
       'backflow_test_report_id' => 'required',
       'contact_id' => 'required',
       'tested_on' => 'required',
    ];

    protected $model_includes = [
       'contact',
       'backflow_test_report'
    ];
    
}