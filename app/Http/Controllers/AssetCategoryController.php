<?php

namespace App\Http\Controllers;

use App\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetCategory::with($includes);
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
        $item = AssetCategory::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_category.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetCategory::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetCategory::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetCategory::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'number' => 'string|max:1',
       'notes' => 'string|max:1073741824|nullable',
       'sort_order' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'number' => 'required',
    ];
}