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
        $client = Client::with('billingContact')
        ->with('mainMailingProperty')
        ->find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql="
			UPDATE
				contacts
			SET
				short_name=:client_name,inactive=:client_status,contact_first=:first_name,contact_last=:last_name,last_update=CURDATE()
			WHERE
				id=:ref_id
		";
        $first = null;
        $last = null;
        if($client->billingContact){
            $names = preg_split('/\s+/',$client->billingContact->name);
            $last = array_pop($names);
            $first = join(' ', $names);
        }
        $values = [
          'client_name'  => $client->name,
          'client_status' => $client->active_level_index > 1 ? '1' : '0',
          'first_name' => $first,
          'last_name' => $last,
          'ref_id' => $client->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        $sql = "UPDATE
				address_book
			SET
				primary_name=:bill_to,contact=:attention_to,address1=:address1,address2=:address2,city_town=:city,state_province=:state,postal_code=:zip,telephone1=:telephone1,telephone2=:telephone2,telephone3=:telephone3,telephone4=:telephone4,email=:email
			WHERE
				address_id=:property_accounting_id AND type='cm';
        ";
        $values = [
          'bill_to'  => $client->billingContact->name,
          'attention_to' => $client->billingContact->name,
          'address1' => $client->mainMailingAddress->address1,
          'address2' => $client->mainMailingAddress->address2,
          'city' => $client->mainMailingAddress->city,
          'state' => $client->mainMailingAddress->state,
          'zip' => $client->mainMailingAddress->zip,
          'telephone1' => $telephone1,
          'telephone2' => $telephone2,
          'telephone3' => $telephone3,
          'telephone4' => $telephone4,
          'email' => $email,
          'ref_id' => $client->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        return $client;
    }

    public function updateContact($id){
        
    }

    public function updateProperty($id){
        
    }


}
