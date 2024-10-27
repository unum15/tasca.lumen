<?php

namespace App\Http\Controllers;

use App\AssetAccessory;
use Illuminate\Http\Request;

class AssetAccessoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetAccessory::with($includes);
        foreach ($values as $field => $value) {
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
        $item = AssetAccessory::create($values);

        return response(['data' => $item], 201, ['Location' => route('asset_accessory.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetAccessory::with($includes)->find($id);

        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetAccessory::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);

        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetAccessory::findOrFail($id);
        $item->delete();

        return response([], 204);
    }

    protected $model_validation = [
        'asset_id' => 'integer|exists:assets,id',
        'quantity' => 'integer',
        'name' => 'string|max:1020',
        'notes' => 'string|max:1020|nullable',
        'value' => 'numeric|nullable',
    ];

    protected $model_validation_required = [
        'asset_id' => 'required',
        'name' => 'required',
    ];

    protected $model_includes = [
        'asset',
    ];
}
