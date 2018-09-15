<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Contact;
use App\Email;
use App\EmailType;

class EmailControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp(){
      parent::setUp();
      $this->contact = Contact::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
      $this->type = EmailType::create(['name' => 'Test Type']);
      $this->item = Email::create(['email' => 'TestEmail@test.com', 'contact_id' => $this->contact->id, 'email_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id]);
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
        $response = $this->get('/emails');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = Email::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = ['email' => 'Tester@test.com', 'contact_id' => $this->contact->id, 'email_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id];
        $response = $this->actingAs($this->contact)->post('/email', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Email::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['email' => ''];
        $response = $this->actingAs($this->contact)->post('/email', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["email" => ["The email field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['email' => "a'; DROP TABLE emails CASCADE; --", 'contact_id' => $this->contact->id, 'email_type_id' => $this->type->id, 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id];
        $response = $this->actingAs($this->contact)->post('/email', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Email::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'email' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->contact)->post('/email', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["email" => ["The email may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->contact)->get('/email/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = Email::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->contact)->get('/email/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['email' => 'Test2@test.com'];
        $response = $this->actingAs($this->contact)->patch('/email/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Email::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->contact)->delete('/email/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
