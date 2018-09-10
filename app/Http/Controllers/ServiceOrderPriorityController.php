<?php

namespace App\Http\Controllers;

use App\ServiceOrderPriority;
use Illuminate\Http\Request;

class ServiceOrderPriorityController extends Controller
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
        $items = ServiceOrderPriority::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ServiceOrderPriority::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = ServiceOrderPriority::find($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ServiceOrderPriority::find($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = ServiceOrderPriority::find($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            ServiceOrderPriority::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            ServiceOrderPriority::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
