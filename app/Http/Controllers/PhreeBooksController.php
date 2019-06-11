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
        $client = Client::with('billingContact')
        ->with('billingContact.phoneNumbers')
        ->with('billingContact.emails')
        ->with('mainMailingProperty')
        ->find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql="
			INSERT INTO contacts
			(type,contacts_level,short_name,inactive,contact_first,contact_last,gl_type_account,dept_rep_id,first_date,last_update)
			VALUES
			('c','r',:client_name,:client_status,:first_name,:last_name,41100,1,CURDATE(),CURDATE())
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
          'last_name' => $last
        ];
        $phreebooks->update($sql, $values);
        $pb_id = $phreebooks->getPdo()->lastInsertId();
        $client->update(['phreebooks_id' => $pb_id]);
        $values = $this->_client_address($client);
        $values['ref_id'] = $pb_id;
        list($phone_numbers, $columns, $params) = $this->_phone_numbers_array($client);
        $values = array_merge($values, $phone_numbers);
        $sql = "
            INSERT INTO address_book
            	(ref_id,type,primary_name,contact,address1,address2,city_town,state_province,postal_code,country_code,email$columns)
            VALUES
                (:ref_id,'cm',:bill_to,:attention_to,:address1,:address2,:city,:state,:zip,'USA',:email$params)
        ";
        $phreebooks->update($sql, $values);
        $pb_id = $phreebooks->getPdo()->lastInsertId();
        foreach($client->contacts as $contact){
            if($contact->phreebooks_id){
                $this->updateContact($contact->id);
            }
            else{
                $this->createContact($contact->id);
            }
        }
        foreach($client->properties as $property){
            if($property->phreebooks_id){
                $this->updateProperty($property->id);
            }
            else{
                $this->createProperty($property->id);
            }
        }
        $client = Client::find($id);
        return $client;
    }

    public function createContact($id){
        $contact = Contact::with('clients')
        ->with('phoneNumbers')
        ->with('emails')
        ->find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql="
            INSERT INTO contacts
                (type,contacts_level,short_name,inactive,contact_first,contact_last,gl_type_account,dept_rep_id,first_date,last_update)
            VALUES
                ('i','r',:name,:status,:first_name,:last_name,41100,:ref_id,CURDATE(),CURDATE())
        ";
        $first = null;
        $last = null;
        $names = preg_split('/\s+/',$contact->name);
        $last = array_pop($names);
        $first = join(' ', $names);
        $values = [
          'name'  => $contact->name,
          'status' => $contact->active_level_index > 1 ? '1' : '0',
          'first_name' => $first,
          'last_name' => $last,
          'ref_id' => $contact->clients[0]->phreebooks_id,
        ];
        $phreebooks->update($sql, $values);
        $pb_id = $phreebooks->getPdo()->lastInsertId();
        $contact->update(['phreebooks_id' => $pb_id]);
        $sql="
            INSERT INTO address_book
                (ref_id,type,primary_name,telephone1,telephone2,telephone3,telephone4,email)
            VALUES
                (:accounting_id,'im',:name,:telephone1,:telephone2,:telephone3,:telephone4,:email)
            ";
        $values = [
            'name'  => $contact->name,
            'telephone1' => count($contact->phoneNumbers) > 0 ? $contact->phoneNumbers[0]->phone_number : null,
            'telephone2' => count($contact->phoneNumbers) > 1 ? $contact->phoneNumbers[1]->phone_number : null,
            'telephone3' => count($contact->phoneNumbers) > 2 ? $contact->phoneNumbers[2]->phone_number : null,
            'telephone4' => count($contact->phoneNumbers) > 3 ? $contact->phoneNumbers[3]->phone_number : null,
            'email' => count($contact->emails) > 0 ? $contact->emails[0]->email : null,
            'accounting_id' => $pb_id
        ];
        $phreebooks->update($sql, $values);
        return $contact;
    }
    
    public function createProperty($id){
        $property = Property::with('client')
        ->find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql = "
            INSERT INTO address_book
                (ref_id,type,primary_name,address1,address2,city_town,state_province,postal_code,country_code,telephone1)
            VALUES
                (:ref_id,'cs',:primary_name,:address1,:address2,:city,:state,:zip,'USA',:telephone1)
        ";
        $values = [
          'primary_name' => $property->name,
          'address1' => $property->address1,
          'address2' => $property->address2,
          'city' => $property->city,
          'state' => $property->state,
          'zip' => $property->zip,
          'telephone1' => $property->phone_number,
          'ref_id' => $property->client->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        return $property;
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
        $values = [
          'bill_to'  => $client->billingContact->name,
          'attention_to' => $client->billingContact->name,
          'address1' => $client->mainMailingProperty->address1,
          'address2' => $client->mainMailingProperty->address2,
          'city' => $client->mainMailingProperty->city,
          'state' => $client->mainMailingProperty->state,
          'zip' => $client->mainMailingProperty->zip,
          'email' => count($client->billingContact->emails) > 0 ? $client->billingContact->emails[0]->email : null,
          'ref_id' => $client->mainMailingProperty->phreebooks_id
        ];
        list($phone_numbers, $columns, $params) = $this->_phone_numbers_array($client);
        $numbers_sql = "";
        if(count($phone_numbers) > 0){
            $values = array_merge($values, $phone_numbers);
            foreach($phone_numbers as $column => $number){
                $numbers_sql .= ",$column=:$column";
            }
            
        }
        $sql = "UPDATE
				address_book
			SET
				primary_name=:bill_to,contact=:attention_to,address1=:address1,address2=:address2,city_town=:city,state_province=:state,postal_code=:zip,email=:email$numbers_sql
			WHERE
				ref_id=:ref_id AND type='cm';
        ";
        $phreebooks->update($sql, $values);
        foreach($client->contacts as $contact){
            if($contact->phreebooks_id){
                $this->updateContact($contact->id);
            }
            else{
                $this->createContact($contact->id);
            }
        }
        foreach($client->properties as $property){
            if($property->phreebooks_id){
                $this->updateProperty($property->id);
            }
            else{
                $this->createProperty($property->id);
            }
        }
        $client = Client::find($id);
        return $client;
    }

    public function updateContact($id){
        $contact = Contact::with('clients')
        ->with('phoneNumbers')
        ->with('emails')
        ->find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql="
            UPDATE contacts SET 
            	short_name=:name,inactive=:status,contact_first=:first_name,contact_last=:last_name,dept_rep_id=:ref_id,last_update=CURDATE()
			WHERE
				id=:accounting_id
		";
        $first = null;
        $last = null;
        $names = preg_split('/\s+/',$contact->name);
        $last = array_pop($names);
        $first = join(' ', $names);
        $values = [
          'name'  => $contact->name,
          'status' => $contact->active_level_index > 1 ? '1' : '0',
          'first_name' => $first,
          'last_name' => $last,
          'ref_id' => $contact->clients[0]->phreebooks_id,
          'accounting_id' => $contact->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        $sql="
            UPDATE address_book
            SET
                primary_name=:name,telephone1=:telephone1,telephone2=:telephone2,telephone3=:telephone3,telephone4=:telephone4,email=:email
            WHERE
                ref_id=:accounting_id
            ";
        $values = [
            'name'  => $contact->name,
            'telephone1' => count($contact->phoneNumbers) > 0 ? $contact->phoneNumbers[0]->phone_number : null,
            'telephone2' => count($contact->phoneNumbers) > 1 ? $contact->phoneNumbers[1]->phone_number : null,
            'telephone3' => count($contact->phoneNumbers) > 2 ? $contact->phoneNumbers[2]->phone_number : null,
            'telephone4' => count($contact->phoneNumbers) > 3 ? $contact->phoneNumbers[3]->phone_number : null,
            'email' => count($contact->emails) > 0 ? $contact->emails[0]->email : null,
            'accounting_id' => $contact->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        return $contact;
    }

    public function updateProperty($id){
        $property = Property::find($id);
        $phreebooks = DB::connection('phreebooks');
        $sql = "UPDATE
				address_book
			SET
				primary_name=:primary_name,address1=:address1,address2=:address2,city_town=:city,state_province=:state,postal_code=:zip,telephone1=:telephone1
			WHERE
				address_id=:address_id AND type='cm';
        ";
        $values = [
          'primary_name' => $property->name,
          'address1' => $property->address1,
          'address2' => $property->address2,
          'city' => $property->city,
          'state' => $property->state,
          'zip' => $property->zip,
          'telephone1' => $property->phone_number,
          'address_id' => $property->phreebooks_id
        ];
        $phreebooks->update($sql, $values);
        return $property;
    }
    
    private function _phone_numbers_array($client){
        $numbers = [];
        $next = 1;
        if($client->mainMailingProperty){
            if($client->mainMailingProperty->phone_number){
                echo $client->mainMailingProperty->phone_number;
                $numbers['telephone' . $next++] = $client->mainMailingProperty->phone_number;
            }
        }
        if($client->billingContact){
            foreach($client->billingContact->phoneNumbers as $number){
                $numbers['telephone' . $next++] = $number->phone_number;
                if($next > 4){
                    break;
                }
            }
        }
        $columns = null;
        $params = null;
        if(count($numbers) > 0){
            $columns = ",".join(',', array_keys($numbers));
            $params = ",:".join(',:', array_keys($numbers));
        }
        return [$numbers, $columns, $params];
    }
    private function _client_address($client){
        $values = [
          'bill_to'  => $client->name,
          'attention_to' => $client->billingContact ? $client->billingContact->name : null,
          'address1' => $client->billingContact ?  $client->mainMailingProperty->address1 : null,
          'address2' => $client->billingContact ?  $client->mainMailingProperty->address2 : null,
          'city' => $client->billingContact ?  $client->mainMailingProperty->city : null,
          'state' => $client->billingContact ?  $client->mainMailingProperty->state : null,
          'zip' => $client->billingContact ?  $client->mainMailingProperty->zip : null,
          'email' => $client->billingContact ? count($client->billingContact->emails) > 0 ? $client->billingContact->emails[0]->email : null : null,
        ];
        return $values;
    }


}
