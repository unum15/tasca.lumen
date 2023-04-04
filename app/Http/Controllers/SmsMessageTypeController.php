<?php

namespace App\Http\Controllers;

use App\SmsMessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsMessageTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = SmsMessageType::with($includes)->orderBy('sort_order')->orderBy('id');
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
        $item = SmsMessageType::create($values);
        return response(['data' => $item], 201, ['Location' => route('sms_message_type.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = SmsMessageType::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = SmsMessageType::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = SmsMessageType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'name' => 'string|max:1073741824',
       'uses_date' => 'boolean',
       'sort_order' => 'integer|nullable',
    ];
    
    protected $model_validation_required = [
       'name' => 'required',
       'uses_date' => 'required',
    ];
}