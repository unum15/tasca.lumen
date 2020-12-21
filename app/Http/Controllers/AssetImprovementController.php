<?php

namespace App\Http\Controllers;

use App\AssetImprovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetImprovementController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetImprovementController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetImprovement::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetImprovement::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_improvement.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetImprovement::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetImprovement::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetImprovement::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'description' => 'string|max:1020',
       'details' => 'string|max:1020|nullable',
       'date' => 'string|max:1020|nullable',
       'cost' => 'numeric|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required',
       'description' => 'required',
    ];

    protected $model_includes = [
       'asset'
    ];
    
}