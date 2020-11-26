<?php

namespace App\Http\Controllers;

use App\AssetRepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetRepairController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetRepairController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetRepair::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetRepair::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_repair.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetRepair::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetRepair::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetRepair::findOrFail($id);
        $item->delete();
        return response([], 204);
    }

    public function unique($field)
    {
        if(!in_array($field,array_keys($this->model_validation))){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'field' => ['Field is not a valid field for Backflow Assembly'],
            ]);
            throw $error;
        }
        $items = AssetRepair::whereNotNull($field)->distinct()->get($field);
        return ['data' => $items];
    }

    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'asset_usage_type_id' => 'integer|exists:asset_usage_types,id',
       'usage' => 'integer|nullable',
       'repair' => 'string|max:1020',
       'date' => 'date|nullable',
       'amount' => 'regex:/[\d\.]+/|nullable',
       'where' => 'string|max:1020|nullable',
       'notes' => 'string|max:1073741824|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required',
       'asset_usage_type_id' => 'required',
       'repair' => 'required',
    ];

    protected $model_includes = [
       'asset_usage_type',
       'asset'
    ];
    
}