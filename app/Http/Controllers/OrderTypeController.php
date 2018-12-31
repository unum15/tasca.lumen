<?php

namespace App\Http\Controllers;

use App\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = OrderType::All();
        return $items;
    }
    
    public function create(Request $request){
        $validation = [
            'name' => 'string|required|min:1|max:255',
            'notes' => 'string|max:255|nullable',
            'sort_order' => 'integer|nullable',
            'service_order_status_id' => 'required|integer|exists:service_order_statuses,id'
        ];
        $this->validate($request, $validation);
        $this->removeConflict($request);
        $item = OrderType::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = OrderType::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $validation = [
            'name' => 'string|min:1|max:255|nullable',
            'notes' => 'string|max:255|nullable',
            'sort_order' => 'integer|nullable',
            'service_order_status_id' => 'integer|exists:service_order_statuses,id'
        ];
        $this->validate($request, $validation);
        $this->removeConflict($request);
        $item = OrderType::findOrFail($id);
        if($item == null){
            return response(['success' => false, 'status' => 404, 'message' => 'HTTP_FILE_NOT_FOUND'], 404);
        }
        $values = $request->only(array_keys($validation));
        //$values = $request->input();
        if(!$values){
            return response(['success' => false, 'status' => 422, 'message' => 'No valid fields given'], 422);
        }
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = OrderType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            OrderType::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            OrderType::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
