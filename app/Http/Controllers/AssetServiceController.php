<?php

namespace App\Http\Controllers;

use App\AssetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetServiceController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetServiceController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetService::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetService::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_service.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetService::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetService::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetService::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'asset_service_type_id' => 'integer|exists:asset_service_types,id',
       'description' => 'string|max:1073741824',
       'quantity' => 'integer',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id',
       'usage_interval' => 'integer',
       'part_number' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
       'time_interval' => 'regex:/\d+\s+\w+/|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required',
       'asset_service_type_id' => 'required',
       'description' => 'required',
       'quantity' => 'required',
       'asset_usage_type_id' => 'required',
       'usage_interval' => 'required',
    ];

    protected $model_includes = [
       'asset_usage_type',
       'asset_service_type',
       'asset'
    ];
    
}