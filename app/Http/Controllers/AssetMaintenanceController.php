<?php

namespace App\Http\Controllers;

use App\AssetMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetMaintenanceController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetMaintenanceController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetMaintenance::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetMaintenance::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_maintenance.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetMaintenance::with($includes)->find($id);
        return ['data' => $item];
    }

    public function last(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetMaintenance::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $item = $items_query->orderByRaw('date DESC NULLS LAST')->first();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetMaintenance::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetMaintenance::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_service_id' => 'integer|exists:asset_services,id',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id',
       'usage' => 'integer|nullable',
       'date' => 'date|nullable',
       'amount' => 'regex:/[\d\.]+/|nullable',
       'where' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_service_id' => 'required',
       'asset_usage_type_id' => 'required',
    ];

    protected $model_includes = [
       'asset_usage_type',
       'asset_service'
    ];
    
}