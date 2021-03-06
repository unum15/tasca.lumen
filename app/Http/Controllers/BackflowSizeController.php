<?php

namespace App\Http\Controllers;

use App\BackflowSize;
use Illuminate\Http\Request;

class BackflowSizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowSize::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowSize::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_size.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowSize::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowSize::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowSize::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'integer|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
    
    protected $model_includes = [
       'backflow_models'
    ];
}