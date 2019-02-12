<?php

namespace App\Http\Controllers;

use App\ActivityLevel;
use Illuminate\Http\Request;

class ActivityLevelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255|nullable',
        'sort_order' => 'integer|nullable',
        'default' => 'boolean'        
    ];
    
    
    public function __construct()
    {
        $this->middleware('auth');
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
    }

    public function index(){
        $items = ActivityLevel::orderBy('sort_order')->get();
        return $items;
    }
    
    public function create(Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ActivityLevel::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = ActivityLevel::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ActivityLevel::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = ActivityLevel::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            ActivityLevel::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            ActivityLevel::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
