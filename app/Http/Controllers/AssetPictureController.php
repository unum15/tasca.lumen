<?php

namespace App\Http\Controllers;

use App\AssetPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetPictureController extends Controller
{
    public function __construct()
    {
        Log::debug('AssetPictureController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AssetPicture::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        if (!$request->hasFile('picture')) {
            return response('No picture attached', 422);
        }
        if (!$request->file('picture')->isValid()) {
            return response('Picture is invalid:', 422);
        }
        $values = $this->validateModel($request, true);
        $values['filename'] = uniqid();
        $values['original_filename'] = $request->file('picture')->getClientOriginalName();
        $request->file('picture')->move('uploads/assets/pictures/', $values['filename']);
        $item = AssetPicture::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset_picture.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AssetPicture::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AssetPicture::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AssetPicture::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'asset_id' => 'integer|exists:assets,id',
       'filename' => 'string|max:1020',
       'original_filename' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'asset_id' => 'required'
    ];

    protected $model_includes = [
       'asset'
    ];
    
}