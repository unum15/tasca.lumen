<?php

namespace App\Http\Controllers;

use App\PartialTextMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartialTextMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = PartialTextMessage::with($includes);
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
        $item = PartialTextMessage::create($values);
        return response(['data' => $item], 201, ['Location' => route('partial_text_message.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = PartialTextMessage::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = PartialTextMessage::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = PartialTextMessage::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'message' => 'string|max:1073741824',
       'sort_order' => 'integer|nullable',
       'partial_text_message_type_id' => 'integer|exists:partial_text_message_types,id',
    ];
    
    protected $model_validation_required = [
       'message' => 'required',
       'partial_text_message_type_id' => 'required',
    ];

    protected $model_includes = [
       'partial_text_message_type'
    ];
    
}