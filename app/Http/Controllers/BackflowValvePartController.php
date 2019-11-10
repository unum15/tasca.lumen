<?php

namespace App\Http\Controllers;

use App\BackflowValvePart;
use Illuminate\Http\Request;

class BackflowValvePartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowValvePart::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowValvePart::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_valve_part.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowValvePart::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowValvePart::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowValvePart::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_style_valve_id' => 'integer|exists:backflow_style_valves,id',
       'name' => 'string|max:1020',
    ];
    
    protected $model_validation_required = [
       'backflow_style_valve_id' => 'required',
       'name' => 'required',
    ];

    protected $model_includes = [
       'backflow_style_valf'
    ];
    
}