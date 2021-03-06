<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetExport;
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
        $items_query->orderBy('id','DESC');
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = Asset::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset.read', ['id' => $item->id])]);
    }
    
    public function createExport($id)
    {
        $values = [
          'asset_id' => $id,
          'exported_at' => date('Y-m-d H:i:s')
        ];
        AssetExport::create($values);
        $item = Asset::with(['asset_exports'])->find($id);
        return response(['data' => $item], 201, ['Location' => route('asset.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = Asset::with($includes)->find($id);
        return ['data' => $item];
    }
    
    public function readNumber($number, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item_query = Asset::with($includes);
        list($category,$brand,$type,$group,$sub,$item_num) = str_split($number);
        if($category){
            $item_query = $item_query->whereHas('asset_category', function($q) use ($category){
                $q->where('number', $category);
            });
        }
        else{
            $item_query = $item_query->whereNull('asset_category_id');
        }
        if($brand){
            $item_query = $item_query->whereHas('asset_brand', function($q) use ($brand){
                $q->where('number', $brand);
            });
        }
        else{
            $item_query = $item_query->whereNull('asset_brand_id');
        }
        if($type){
            $item_query = $item_query->whereHas('asset_type', function($q) use ($type){
                $q->where('number', $type);
            });
        }
        else{
            $item_query = $item_query->whereNull('asset_type_id');
        }
        if($group){
            $item_query = $item_query->whereHas('asset_group', function($q) use ($group){
                $q->where('number', $group);
            });
        }
        else{
            $item_query = $item_query->whereNull('asset_group_id');
        }
        if($sub){
            $item_query = $item_query->whereHas('asset_sub', function($q) use ($sub){
                $q->where('number', $sub);
            });
        }
        else{
            $item_query = $item_query->whereNull('asset_sub_id');
        }
        if($item_num){
            $item_query = $item_query->where('item_number',$item_num);
        }
        else{
            $item_query = $item_query->whereNull('item_number');
        }
        $item = $item_query->get()->first();
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
       'asset_category_id' => 'integer|exists:asset_categories,id|nullable',
       'asset_brand_id' => 'integer|exists:asset_brands,id|nullable',
       'asset_type_id' => 'integer|exists:asset_types,id|nullable',
       'asset_group_id' => 'integer|exists:asset_groups,id|nullable',
       'asset_sub_id' => 'integer|exists:asset_subs,id|nullable',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id|nullable',
       'item_number' => 'string|max:1|nullable',
       'year' => 'integer|nullable',
       'make' => 'string|max:1020|nullable',
       'model' => 'string|max:1020|nullable',
       'trim' => 'string|max:1020|nullable',
       'vin' => 'string|max:1020|nullable',
       'parent_asset_id' => 'integer|nullable',
       'notes' => 'string|max:1073741824|nullable',
       'asset_location_id' => 'integer|exists:asset_locations,id|nullable',
       'manufacture' => 'string|max:1020|nullable',
       'number' => 'string|max:1020|nullable',
       'purchase_cost' => 'numeric|nullable',
       'purchase_date' => 'date|nullable'
    ];
    
    protected $model_validation_required = [
       'name' => 'required'
    ];

    protected $model_includes = [
       'asset_usage_type',
       'asset_category',
       'asset_brand',
       'asset_type',
       'asset_group',
       'asset_sub',
       'parent_asset',
       'asset_location',
       'asset_exports'
    ];
    
}