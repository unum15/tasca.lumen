<?php

namespace App\Http\Controllers;

use App\Client;
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
        'notes' => 'nullable|string|max:255',
		'activity_level_id' => 'nullable|integer|exists:activity_levels,id',
        'contact_method_id' => 'nullable|integer|exists:contact_methods,id',
        'show_help' => 'boolean',
        'show_maximium_activity_level_id' => 'integer|exists:activity_levels,id|nullable',
		'login' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $items_query = Contact::with('clients')
        ->with('activityLevel')
        ->with('contactMethod')
        ->with('emails')
        ->with('phoneNumbers')
        ->orderBy('name');
        $client_id = $request->input('client_id');
        if($client_id){
            $items_query->whereHas('clients', function($q) use ($client_id){
                $q->where('client_id', $client_id);
            });
        }
        $items = $items_query->get();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, ['name' => 'required']);
        $this->validate($request, $this->validation);
        $this->validate($request, ['client_id' => 'integer|exists:clients,id']);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Contact::create($values);
        $item = Contact::findOrFail($item->id);
        $client_id = $request->input('client_id');
        if($client_id){
            $this->validate($request, ['contact_type_id' => 'required|integer|exists:contact_types,id']);
            $contact_type_id = $request->input('contact_type_id');
            $client = Client::findOrFail($client_id);
            $item->clients()->attach($client, ['contact_type_id' => $contact_type_id]);
        }
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
        if(!empty($values['password'])){
            $values['password'] = password_hash($values['password'], PASSWORD_DEFAULT);
        }
        $item->update($values);
        $client_id = $request->input('client_id');
        if($client_id){
            if(!$item->clients->contains($client_id)){
                $this->validate($request, ['contact_type_id' => 'required|integer|exists:contact_types,id']);
                $contact_type_id = $request->input('contact_type_id');
                $client = Client::findOrFail($client_id);
                $item->clients()->attach($client, ['contact_type_id' => $contact_type_id]);
            }
        }
        $properties = $request->only('properties');
        if($properties){
            $item->properties()->sync($properties['properties']);
        }
        return $item;
    }
    
    public function delete($id){
        $item = Contact::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
