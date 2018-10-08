<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\ActivityLevel;
use App\PropertyType;
use App\Client;
use App\Contact;
use App\Property;

class PropertyControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp(){
        parent::setUp();
        $this->contact = Contact::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
        $this->client = Client::create(['name' => 'Test Contact', 'creator_id' => 1, 'updater_id' => 1]);
        $this->activity_level = ActivityLevel::create(['name' => 'Test Level']);
        $this->property_type = PropertyType::create(['name' => 'Test Type']);
        $this->item = Property::create([
            'name' => 'Test Type',
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ]);

    }
    
    public function tearDown(){
        parent::tearDown();      
        if(isset($this->item)){
          $this->item->delete();
        }
        $this->property_type->delete();
        $this->activity_level->delete();
        $this->client->delete();
        $this->contact->delete();
    }
    
    
    public function testIndex()
    {
        $response = $this->get('/propertys');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = Property::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = [
            'name' => 'Test Property',
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateFull()
    {
        $item = [
            'name' => 'Test Property',
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testCreateBad()
    {
        $item = [
            'name' => '',
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/property', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = [
            'name' => "a'; DROP TABLE propertys CASCADE; --",
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'activity_level_id' => $this->activity_level->id,
            'property_type_id' => $this->property_type->id,
            'client_id' => $this->client->id,
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/property', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->contact)->get('/property/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = Property::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->contact)->get('/property/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['name' => 'Test Property 2'];
        $response = $this->actingAs($this->contact)->patch('/property/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Property::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->contact)->delete('/property/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
