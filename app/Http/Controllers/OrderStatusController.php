<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
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
        $items = OrderStatus::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = OrderStatus::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = OrderStatus::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = OrderStatus::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = OrderStatus::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            OrderStatus::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            OrderStatus::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
