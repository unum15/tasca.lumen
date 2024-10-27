<?php

namespace App\Http\Controllers;

use App\StockTextMessage;
use Illuminate\Http\Request;

class StockTextMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = StockTextMessage::with($includes)->orderBy('sort_order')->orderBy('id');
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
        $item = StockTextMessage::create($values);

        return response(['data' => $item], 201, ['Location' => route('stock_text_message.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = StockTextMessage::with($includes)->find($id);

        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = StockTextMessage::findOrFail($id);
        $values['updater_id'] = $request->user()->id;
        $values = $this->validateModel($request);
        $item->update($values);

        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = StockTextMessage::findOrFail($id);
        $item->delete();

        return response([], 204);
    }

    protected $model_validation = [
        'message' => 'string|max:1073741824',
    ];

    protected $model_validation_required = [
        'message' => 'required',
    ];
}
