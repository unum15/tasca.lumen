<?php

namespace App\Http\Controllers;

use App\OrderCategory;
use Illuminate\Http\Request;

class OrderCategoryController extends Controller
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
        $items = OrderCategory::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = OrderCategory::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = OrderCategory::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = OrderCategory::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = OrderCategory::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            OrderCategory::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            OrderCategory::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
