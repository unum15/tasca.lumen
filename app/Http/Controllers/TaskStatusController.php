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
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255',
        'sort_order' => 'integer',
        'default' => 'boolean'        
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = TaskStatus::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskStatus::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = TaskStatus::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskStatus::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = TaskStatus::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            TaskStatus::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            TaskStatus::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
