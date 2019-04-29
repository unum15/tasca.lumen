<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contact;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhreeBooksController extends Controller
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
        //$this->middleware('auth');
    }

    public function contacts(Request $request){
        $phreebooks = DB::connection('phreebooks');
        $contacts = $phreebooks->select("SELECT * FROM contacts;");
        foreach($contacts as $index => $contact){
            if($contact->type == 'i'){
                $contacts[$index]->tasca = Contact::where('phreebooks_id', $contact->id)->first();
            }
            else{
                $contacts[$index]->tasca = Client::where('phreebooks_id', $contact->id)->first();
            }
        }
        return $contacts;
    }
    
    public function addresses(Request $request){
        $phreebooks = DB::connection('phreebooks');
        $addresses = $phreebooks->select("SELECT * FROM address_book;");
        foreach($addresses as $index => $address){
            $addresses[$index]->tasca = Property::where('phreebooks_id', $address->address_id)->first();
        }
        return $addresses;
    }
    
    
    public function matches(Request $request){
        $phreebooks = DB::connection('phreebooks');
        $clients = Client::with('contacts')
        ->with('properties')
        ->whereNotNull('phreebooks_id')
        ->get();
        $pb_contacts_array = $phreebooks->select("SELECT * FROM contacts;");
        $pb_contacts = [];
        foreach($pb_contacts_array as $pb_contact){
            $pb_contacts[$pb_contact->id] = $pb_contact;
        }
        foreach($clients as $index => $client){
            $clients[$index]->phree_books = $pb_contacts[$client->phreebooks_id];
            foreach($client->contacts as $contact_index => $contact){
                
                if(($contact->phreebooks_id)&&(isset($pb_contacts[$contact->phreebooks_id]))){
                    $clients[$index]->contacts[$contact_index]->phree_books = $pb_contacts[$contact->phreebooks_id];
                }
            }
        }
        return $clients;
    }
    
    
    public function createClient($id){
        
    }

    public function createContact($id){
        
    }
    
    public function createProperty($id){
        
    }

    public function updateClient($id){
        $client = Client::find($id);
        return $client;
    }

    public function updateContact($id){
        
    }

    public function updateProperty($id){
        
    }


}
