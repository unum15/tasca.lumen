<?php

namespace App\Http\Controllers;

use App\OrderStatusType;
use Illuminate\Http\Request;

class OrderStatusTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */    

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $items = OrderStatusType::All();
        return $items;
    }
    
    public function create(Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $validation = [
            'name' => 'string|required|min:1|max:255',
            'notes' => 'string|max:255'
        ];
        $this->validate($request, $validation);
        $item = OrderStatusType::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = OrderStatusType::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $validation = [
            'name' => 'string|min:1|max:255|nullable',
            'notes' => 'string|max:255|nullable',
            'sort_order' => 'integer|nullable',
            'service_order_status_id' => 'integer|exists:service_order_statuses,id'
        ];
        $this->validate($request, $validation);
        $this->removeConflict($request);
        $item = OrderStatusType::findOrFail($id);
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
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = OrderStatusType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
}
