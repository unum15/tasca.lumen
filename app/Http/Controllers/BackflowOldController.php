<?php

namespace App\Http\Controllers;

use App\BackflowOld;
use Illuminate\Http\Request;

class BackflowOldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowOld::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowOld::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_old.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowOld::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowOld::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowOld::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'active' => 'string|max:1020',
       'prt' => 'string|max:1020',
       'month' => 'string|max:1020',
       'reference' => 'string|max:1020',
       'water_system' => 'string|max:1020',
       'account' => 'string|max:1020',
       'owner' => 'string|max:1020',
       'contact' => 'string|max:1020',
       'email' => 'string|max:1020',
       'phone' => 'string|max:1020',
       'address' => 'string|max:1020',
       'city' => 'string|max:1020',
       'state' => 'string|max:1020',
       'zip' => 'string|max:1020',
       'location' => 'string|max:1020',
       'laddress' => 'string|max:1020',
       'lcity' => 'string|max:1020',
       'lstate' => 'string|max:1020',
       'lzip' => 'string|max:1020',
       'gps' => 'string|max:1020',
       'use' => 'string|max:1020',
       'placement' => 'string|max:1020',
       'style' => 'string|max:1020',
       'manufacturer' => 'string|max:1020',
       'size' => 'string|max:1020',
       'model' => 'string|max:1020',
       'serial' => 'string|max:1020',
    ];
    
    protected $model_validation_required = [
       'active' => 'required',
       'prt' => 'required',
       'month' => 'required',
       'reference' => 'required',
       'water_system' => 'required',
       'account' => 'required',
       'owner' => 'required',
       'contact' => 'required',
       'email' => 'required',
       'phone' => 'required',
       'address' => 'required',
       'city' => 'required',
       'state' => 'required',
       'zip' => 'required',
       'location' => 'required',
       'laddress' => 'required',
       'lcity' => 'required',
       'lstate' => 'required',
       'lzip' => 'required',
       'gps' => 'required',
       'use' => 'required',
       'placement' => 'required',
       'style' => 'required',
       'manufacturer' => 'required',
       'size' => 'required',
       'model' => 'required',
       'serial' => 'required',
    ];
}