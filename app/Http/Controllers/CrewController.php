<?php

namespace App\Http\Controllers;

use App\Crew;
use Illuminate\Http\Request;

class CrewController extends Controller
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

    public function index(){
        $items = Crew::orderBy('sort_order')->get();
        return $items;
    }
    
    public function create(Request $request){
        if(!$request->user()->can('edit-crews')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = Crew::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = Crew::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        if(!$request->user()->can('edit-crews')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = Crew::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        if(!$request->user()->can('edit-crews')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = Crew::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            Crew::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            Crew::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
