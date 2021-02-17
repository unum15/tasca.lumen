<?php

namespace App\Http\Controllers;

use App\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetType::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items_query->orderBy('number');
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = AssetType::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_type.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetType::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetType::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'string|max:1020|nullable',
       'asset_brand_id' => 'integer|exists:asset_brands,id',
       'number' => 'string|max:1',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'asset_brand_id' => 'required',
       'number' => 'required',
    ];

    protected $model_includes = [
       'asset_brand'
    ];
    
}