<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation_create = [
        'email' => 'string|required|min:1|max:255',
		'email_type_id' => 'integer|required|exists:email_types,id',		
		'contact_id' => 'integer|required|exists:contacts,id'
    ];
    
    private $validation = [
        'email' => 'string|min:1|max:255',
		'email_type_id' => 'integer|exists:email_types,id',		
		'contact_id' => 'integer|exists:contacts,id'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = Email::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation_create);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Email::create($values);
        $item = Email::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Email::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Email::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Email::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
