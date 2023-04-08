<?php

namespace App\Http\Controllers;

use App\PartialTextMessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartialTextMessageTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = PartialTextMessageType::with($includes);
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
        $item = PartialTextMessageType::create($values);
        return response(['data' => $item], 201, ['Location' => route('partial_text_message_type.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = PartialTextMessageType::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = PartialTextMessageType::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = PartialTextMessageType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1020',
       'sort_order' => 'integer|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
    ];
}