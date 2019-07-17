<?php

namespace App\Http\Controllers;

use App\OrderAction;
use Illuminate\Http\Request;

class OrderActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $items = OrderAction::with('orderStatuses')->get();
        return $items;
    }
    
    public function create(Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $validation = [
            'name' => 'string|required|min:1|max:255',
            'notes' => 'string|max:255',
            'sort_order' => 'integer'
        ];
        $this->validate($request, $validation);
        $this->removeConflict($request);
        $item = OrderAction::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = OrderAction::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $validation = [
            'name' => 'string|min:1|max:255',
            'notes' => 'string|max:255|nullable',
            'sort_order' => 'integer|nullable',
        ];
        $this->validate($request, $validation);
        $this->removeConflict($request);
        $item = OrderAction::findOrFail($id);
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
    
    public function delete(Request $request, $id){
        if(!$request->user()->can('edit-settings')){
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = OrderAction::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        if($sort_order){
            OrderAction::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        } 
    }
}
