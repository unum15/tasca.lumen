<?php

namespace App\Http\Controllers;

use App\TaskAction;
use Illuminate\Http\Request;

class TaskActionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $model_validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255|nullable',
        'labor_types' => 'array'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = TaskAction::with('labor_types')->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $values = $this->validateModel($request);
        $item = TaskAction::create($values);
        $item->labor_types()->sync($values['labor_types']);
        return $item;
    }
    
    public function read($id)
    {
        $item = TaskAction::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $values = $this->validateModel($request);
        $item = TaskAction::findOrFail($id);
        $item->update($values);
        if(isset($values['labor_types'])){
            $item->labor_types()->sync($values['labor_types']);
        }
        return $item;
    }
    
    public function delete(Request $request, $id)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = TaskAction::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
}
