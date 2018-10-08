<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|required|min:1|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = Setting::pluck('value', 'name');
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $item = ContactMethod::Setting($request->input());
        return $item;
    }
    
    public function read($id){
        $item = Setting::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $item = Setting::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = Setting::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
}
