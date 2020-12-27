<?php

namespace App\Http\Controllers;

use App\AssetFueling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetFuelingController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetFuelingController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetFueling::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetFueling::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_fueling.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetFueling::with($includes)->find($id);
        return ['data' => $item];
    }

    public function last(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetFueling::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $item = $items_query->orderByRaw('date DESC NULLS LAST')->first();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetFueling::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetFueling::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id',
       'usage' => 'integer|nullable',
       'date' => 'date|nullable',
       'gallons' => 'regex:/[\d\.]+/|nullable',
       'amount' => 'regex:/[\d\.]+/|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required',
       'asset_usage_type_id' => 'required',
    ];

    protected $model_includes = [
       'asset',
       'asset_usage_type'
    ];
    
}