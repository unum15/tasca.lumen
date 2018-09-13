<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255',
		'client_type_id' => 'integer|exists:client_types,id',
		'activity_level_id' => 'integer|exists:activity_levels,id',
		'billing_contact_id' => 'integer|exists:contacts,id',
		'billing_property_id' => 'integer|exists:properties,id',
		'contact_method_id' => 'integer|exists:contact_methods,id',
		'referred_by' => 'string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = Client::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Client::create($values);
        $item = Client::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Client::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Client::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Client::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
