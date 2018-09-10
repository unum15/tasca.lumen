<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\ServiceOrderAction;
use App\ServiceOrderStatus;

class ServiceOrderActionControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(){
      parent::setUp();
      $this->status = ServiceOrderStatus::create(['name' => 'Test Status']);
      $this->item = ServiceOrderAction::create(['name' => 'Test Action', 'service_order_status_id' => $this->status->id]);      
    }
    
    public function tearDown(){
      parent::tearDown();
      $this->status->delete();
      if(isset($this->item)){
        $this->item->delete();
      }      
    }
    
    public function testIndex()
    {        
        $response = $this->get('/service_order_actions');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());
        $dbitems = ServiceOrderAction::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'service_order_status_id' => $this->status->id];
        $response = $this->post('/service_order_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = ServiceOrderAction::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a', 'service_order_status_id' => 'a'];
        $response = $this->post('/service_order_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["default" => ["The default field must be true or false."],"name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE service_order_actions CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --", 'service_order_status_id' => $this->status->id];
        $response = $this->post('/service_order_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = ServiceOrderAction::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'service_order_status_id' => $this->status->id
        ];
        $response = $this->post('/service_order_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()    {        
        
        $response = $this->get('/service_order_action/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());        
        //$response->seeJsonEquals($this->item->toArray());
    }
    
    
    public function testReadBad()
    {
        $response = $this->get('/service_order_action/a');
        $response->seeStatusCode(404);        
    }
    
    public function testCreateDoubleDefault()
    {
        $items = [
                  ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'service_order_status_id' => $this->status->id],
                  ['name' => 'Test 2', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'service_order_status_id' => $this->status->id]
                ];
        $response = $this->post('/service_order_action',$items[0]);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());        
        $response = $this->post('/service_order_action',$items[1]);
        $response->seeStatusCode(200);                
        $dbitem = ServiceOrderAction::find($response_array->id);
        $this->assertEquals(false, $dbitem->default);
        $this->assertEquals(null, $dbitem->sort_order);
    }
    
    public function testUpdate()
    {
      $patch = ['name' => 'Test 2'];
      $response = $this->patch('/service_order_action/' . $this->item->id, $patch);
      $response->seeStatusCode(200);
      $response->seeJson($patch);
      $dbitem = ServiceOrderAction::find($this->item->id);
      $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testEmptyUpdate()
    {      
      $response = $this->patch('/service_order_action/' . $this->item->id, []);
      $response->seeStatusCode(422);      
    }
    
    public function testDelete()
    {      
      $response = $this->delete('/service_order_action/' . $this->item->id);
      $response->seeStatusCode(204);        
      $response->seeJsonEquals([]);
    }
    
    
}
