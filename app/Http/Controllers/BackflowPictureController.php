<?php

namespace App\Http\Controllers;

use App\BackflowPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BackflowPictureController extends Controller
{
    public function __construct()
    {
        Log::debug('BackflowPictureController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowPicture::with($includes);
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
        $request->file('picture')->move(public_path().'/uploads/backflows/pictures/', $values['filename']);
        $item = BackflowPicture::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_picture.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowPicture::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowPicture::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowPicture::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'backflow_assembly_id' => 'integer|exists:backflow_assemblies,id',
       'filename' => 'string|max:1020',
       'original_filename' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'backflow_assembly_id' => 'required'
    ];

    protected $model_includes = [
       'backflow_assembly'
    ];
    
}
