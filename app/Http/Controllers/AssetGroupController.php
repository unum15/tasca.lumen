<?php

namespace App\Http\Controllers;

use App\AssetGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetGroup::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = AssetGroup::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_group.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetGroup::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetGroup::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetGroup::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_type_id' => 'integer|exists:asset_types,id',
       'name' => 'string|max:1020',
       'number' => 'string|max:1',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_type_id' => 'required',
       'name' => 'required',
       'number' => 'required',
    ];

    protected $model_includes = [
       'asset_type'
    ];
    
}