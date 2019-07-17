<?php

use App\OrderAction;
use App\OrderStatus;

class OrderActionControllerTest extends TestCase
{
    public function testIndex()
    {
        $item = factory('App\OrderAction')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order_actions');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1];
        $response = $this->actingAs($this->getAdminUser())->post('/order_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = OrderAction::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a'];
        $response = $this->actingAs($this->getAdminUser())->post('/order_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $status = factory('App\OrderStatus')->create();
        $item = ['name' => "a'; DROP TABLE order_actions CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/order_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = OrderAction::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $status = factory('App\OrderStatus')->create();
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'order_status_id' => $status->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {   
        $item = factory('App\OrderAction')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order_action/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
    }
    
    
    public function testReadBad()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/order_action/a');
        $response->seeStatusCode(404);        
    }
    
    public function testUpdate()
    {
        $item = factory('App\OrderAction')->create();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/order_action/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = OrderAction::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testEmptyUpdate()
    {
        $item = factory('App\OrderAction')->create();
        $response = $this->actingAs($this->getAdminUser())->patch('/order_action/' . $item->id, []);
        $response->seeStatusCode(422);      
    }
    
    public function testDelete()
    {
        $item = factory('App\OrderAction')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/order_action/' . $item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }

    public function testAuth()
    {
        $response = $this->get('/order_actions/');
        $response->seeStatusCode(401);
    }

}
