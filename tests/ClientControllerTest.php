<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Client;
use App\Contact;

class ClientControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp(){
      parent::setUp();
      $this->contact = Contact::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
      $this->item = Client::create(['name' => 'Test Client', 'creator_id' => $this->contact->id, 'updater_id' => $this->contact->id]);
    }
    
    public function tearDown(){
      parent::tearDown();
      if(isset($this->item)){
        $this->item->delete();
      }      
    }
    
    
    public function testIndex()
    {
        $response = $this->get('/clients');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = Client::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1'];
        $response = $this->actingAs($this->contact)->post('/client', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Client::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => ''];
        $response = $this->actingAs($this->contact)->post('/client', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE clients CASCADE; --"];
        $response = $this->actingAs($this->contact)->post('/client', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Client::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->contact)->post('/client', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->contact)->get('/client/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = Client::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->contact)->get('/client/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->contact)->patch('/client/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Client::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->contact)->delete('/client/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
