<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = Asset::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Asset::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Asset::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Asset::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Asset::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'asset_type_id' => 'integer|exists:asset_types,id',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id|nullable',
       'year' => 'integer|nullable',
       'make' => 'string|max:1020|nullable',
       'model' => 'string|max:1020|nullable',
       'trim' => 'string|max:1020|nullable',
       'vin' => 'string|max:1020|nullable',
       'parent_asset_id' => 'integer|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'asset_type_id' => 'required'
    ];

    protected $model_includes = [
       'asset_usage_type',
       'asset_type',
       'parent_asset'
    ];
    
}