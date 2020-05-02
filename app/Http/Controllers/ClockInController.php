<?php

namespace App\Http\Controllers;

use App\ClockIn;
use Illuminate\Http\Request;

class ClockInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = ClockIn::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $values['contact_id'] = $values['contact_id'] ?? $request->user()->id;
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = ClockIn::create($values);
        return response(['data' => $item], 201, ['Location' => route('clock_in.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = ClockIn::with($includes)->find($id);
        return ['data' => $item];
    }
    
    public function current(Request $request)
    {
        $item = ClockIn::where('contact_id', $request->user()->id)->whereRaw('clock_in::DATE=NOW()::DATE')->orderByDesc('clock_in')->first();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = ClockIn::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = ClockIn::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'contact_id' => 'integer|exists:contacts,id',
       'clock_in' => 'date',
       'clock_out' => 'date|nullable',
       'notes' => 'string|max:1073741824|nullable',
       'creator_id' => 'integer',
       'updater_id' => 'integer',
    ];
    
    protected $model_validation_required = [
       'clock_in' => 'required',
    ];

    protected $model_includes = [
       'contact'
    ];
    
}