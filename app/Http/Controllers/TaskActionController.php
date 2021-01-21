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
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255|nullable',
        'sort_order' => 'integer|nullable'
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
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskAction::create($request->input());
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
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskAction::findOrFail($id);
        $item->update($request->input());
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
    
    public function removeConflict(Request $request)
    {
        $sort_order = $request->input('sort_order');
        if($sort_order) {
            TaskAction::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }      
    }
}
