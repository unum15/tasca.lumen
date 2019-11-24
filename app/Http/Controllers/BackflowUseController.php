<?php

namespace App\Http\Controllers;

use App\BackflowUse;
use Illuminate\Http\Request;

class BackflowUseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowUse::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowUse::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_us.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowUse::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowUse::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowUse::findOrFail($id);
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
}