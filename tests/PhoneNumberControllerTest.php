<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Contact;
use App\PhoneNumber;
use App\PhoneNumberType;

class PhoneNumberControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp(){
      parent::setUp();
      $this->contact = Contact::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
      $this->type = PhoneNumberType::create(['name' => 'Test Type']);
      $this->item = PhoneNumber::create(['phone_number' => '5555555555', 'contact_id' => $this->contact->id, 'phone_number_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id]);
    }
    
    public function tearDown(){
      parent::tearDown();      
      if(isset($this->item)){
        $this->item->delete();
      }
      $this->contact->delete();
      $this->type->delete();
    }
    
    
    public function testIndex()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = PhoneNumber::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = ['phone_number' => '8005555555', 'contact_id' => $this->contact->id, 'phone_number_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id];
        $response = $this->actingAs($this->contact)->post('/phone_number', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = PhoneNumber::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['phone_number' => ''];
        $response = $this->actingAs($this->contact)->post('/phone_number', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["phone_number" => ["The phone number field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['phone_number' => "a'; DROP TABLE phone_numbers CASCADE; --", 'contact_id' => $this->contact->id, 'phone_number_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id];
        $response = $this->actingAs($this->contact)->post('/phone_number', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['phone_number' => ["The phone number format is invalid.","The phone number may not be greater than 10 characters."]]);        
    }
    
    public function testCreateLong()
    {
        $item = [
            'phone_number' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->contact)->post('/phone_number', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['phone_number' => ["The phone number format is invalid.","The phone number may not be greater than 10 characters."]]);        
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->contact)->get('/phone_number/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = PhoneNumber::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->contact)->get('/phone_number/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['phone_number' => '8005555555'];
        $response = $this->actingAs($this->contact)->patch('/phone_number/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = PhoneNumber::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->contact)->delete('/phone_number/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
