<?php

namespace App\Http\Controllers;

use App\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
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
        $items = TaskStatus::with('labor_types')->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->model_validation);
        $this->removeConflict($request);
        $item = TaskStatus::create($request->input());
        return $item;
    }
    
    public function read($id)
    {
        $item = TaskStatus::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $values = $this->validateModel($request);
        $item = TaskStatus::findOrFail($id);
        $item->update($values);
        if(isset($values['labor_types'])){
            $item->labor_types()->sync($values['labor_types']);
        }
        return $item;
    }
    
    public function delete($id, Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = TaskStatus::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
}
