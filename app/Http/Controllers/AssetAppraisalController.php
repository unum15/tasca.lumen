<?php

namespace App\Http\Controllers;

use App\AssetAppraisal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetAppraisalController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetAppraisalController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetAppraisal::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AssetAppraisal::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_appraisal.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetAppraisal::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetAppraisal::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetAppraisal::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'date' => 'string|max:1020',
       'appraisal' => 'numeric',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required',
       'date' => 'required',
       'appraisal' => 'required',
    ];

    protected $model_includes = [
       'asset'
    ];
    
}