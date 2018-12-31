<?php

namespace App\Http\Controllers;

use App\PhoneNumberType;
use Illuminate\Http\Request;

class PhoneNumberTypeController extends Controller
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
        $items = PhoneNumberType::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = PhoneNumberType::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = PhoneNumberType::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = PhoneNumberType::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = PhoneNumberType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            PhoneNumberType::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
        if($default){
            PhoneNumberType::where('default', true)
            ->update(['default' => false]);
        }        
    }
}
