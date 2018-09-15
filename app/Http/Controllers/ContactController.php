<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|min:1|max:255',
        'notes' => 'string|max:255',		
		'activity_level_id' => 'integer|exists:activity_levels,id',
        'contact_method_id' => 'integer|exists:contact_methods,id',		
		'login' => 'string|max:255',
        'password' => 'string|max:255'        
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = Contact::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, ['name' => 'required']);
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Contact::create($values);
        $item = Contact::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Contact::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Contact::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Contact::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
