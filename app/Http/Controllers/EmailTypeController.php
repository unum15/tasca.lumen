<?php

namespace App\Http\Controllers;

use App\EmailType;
use Illuminate\Http\Request;

class EmailTypeController extends Controller
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
        $items = EmailType::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = EmailType::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = EmailType::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = EmailType::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = EmailType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            EmailType::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            EmailType::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
