<?php

namespace App\Http\Controllers;

use App\ClientType;
use Illuminate\Http\Request;

class ClientTypeController extends Controller
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
        $items = ClientType::orderBy('sort_order')->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ClientType::create($request->input());
        return $item;
    }
    
    public function read($id)
    {
        $item = ClientType::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = ClientType::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete(Request $request, $id)
    {
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = ClientType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request)
    {
        $sort_order = $request->input('sort_order');
        if($sort_order) {
            ClientType::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
    }
}
