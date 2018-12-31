<?php

namespace App\Http\Controllers;

use App\TaskCategory;
use Illuminate\Http\Request;

class TaskCategoryController extends Controller
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
        //
    }

    public function index(){
        $items = TaskCategory::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskCategory::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = TaskCategory::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskCategory::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = TaskCategory::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            TaskCategory::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            TaskCategory::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
