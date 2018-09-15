<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Contact;

class ContactControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp(){
      parent::setUp();
      $this->item = Contact::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
    }
    
    public function tearDown(){
      parent::tearDown();
      if(isset($this->item)){
        $this->item->delete();
      }      
    }
    
    
    public function testIndex()
    {
        $response = $this->get('/contacts');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = Contact::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1'];
        $response = $this->actingAs($this->item)->post('/contact', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Contact::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => ''];
        $response = $this->actingAs($this->item)->post('/contact', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE contacts CASCADE; --"];
        $response = $this->actingAs($this->item)->post('/contact', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Contact::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->item)->post('/contact', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->item)->get('/contact/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = Contact::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->item)->get('/contact/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->item)->patch('/contact/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Contact::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->item)->delete('/contact/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
