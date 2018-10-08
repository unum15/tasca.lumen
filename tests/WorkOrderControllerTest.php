<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\ActivityLevel;
use App\PropertyType;
use App\Client;
use App\Contact;
use App\WorkOrder;
use App\Property;

class WorkOrderControllerTest extends TestCase
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
        $this->property = Property::create(['name' => 'Test Type', 'activity_level_id' => $this->activity_level->id, 'property_type_id' => $this->property_type->id, 'client_id' => $this->client->id, 'creator_id' => 1, 'updater_id' => 1]);
        $this->item = WorkOrder::create([
            'name' => 'Test WorkOrder',
            //'contact_id' => $this->contact->id,
            //'property_id' => $this->property->id,
            //'open_date' => date('Y-m-d'),
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ]);
    }
    
    public function tearDown(){
        parent::tearDown();      
        if(isset($this->item)){
          $this->item->delete();
        }
        $this->property->delete();
        $this->property_type->delete();
        $this->activity_level->delete();
        $this->client->delete();
        $this->contact->delete();
    }
    
    
    public function testIndex()
    {
        $response = $this->get('/work_orders');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitems = WorkOrder::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $item = [
            'contact_id' => $this->contact->id,
            'property_id' => $this->property->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/work_order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = WorkOrder::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateFull()
    {
        $item = [
            'contact_id' => $this->contact->id,
            'property_id' => $this->property->id,
            'open_date' => date('Y-m-d'),
            'close_date' => date('Y-m-d'),
            'notes' => 'foo',            
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/work_order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = WorkOrder::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testCreateBad()
    {
        $item = [
            'contact_id' => null,
            'property_id' => $this->property->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/work_order', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = [
            'location' => "a'; DROP TABLE work_orders CASCADE; --",
            'contact_id' => $this->contact->id,
            'property_id' => $this->property->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/work_order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = WorkOrder::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'location' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'contact_id' => $this->contact->id,
            'property_id' => $this->property->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $this->contact->id,
            'updater_id' => $this->contact->id
        ];
        $response = $this->actingAs($this->contact)->post('/work_order', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->actingAs($this->contact)->get('/work_order/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        $dbitem = WorkOrder::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->contact)->get('/work_order/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {        
        $patch = ['location' => 'Test WorkOrder 2'];
        $response = $this->actingAs($this->contact)->patch('/work_order/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = WorkOrder::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {        
        $response = $this->actingAs($this->contact)->delete('/work_order/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
