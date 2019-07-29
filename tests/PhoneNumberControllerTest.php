<?php

use App\Contact;
use App\PhoneNumber;
use App\PhoneNumberType;

class PhoneNumberControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/phone_numbers');
        $response->seeStatusCode(200);
        $dbitems = PhoneNumber::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }

    public function testCreate()
    {
        $contact = Contact::first();
        $type = PhoneNumberType::first();
        $item = ['phone_number' => '8005555555', 'contact_id' => $contact->id, 'phone_number_type_id' => $type->id];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = PhoneNumber::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }

    public function testCreateBad()
    {
        $item = ['phone_number' => ''];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["phone_number" => ["The phone number field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $contact = Contact::first();
        $type = PhoneNumberType::first();
        $item = ['phone_number' => "a'; DROP TABLE phone_numbers CASCADE; --", 'contact_id' => $contact->id, 'phone_number_type_id' => $type->id];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = PhoneNumber::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $item = [
            'phone_number' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['phone_number' => ["The phone number may not be greater than 64 characters."]]);        
    }
    
    public function testRead()
    {
        $item = PhoneNumber::first();
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = PhoneNumber::first();
        $patch = ['phone_number' => '8005555555'];
        $response = $this->actingAs($this->getAdminUser())->patch('/phone_number/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = PhoneNumber::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\PhoneNumber')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/phone_number/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(401);
    }
}
