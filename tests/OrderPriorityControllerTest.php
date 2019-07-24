<?php

use App\OrderPriority;

class OrderPriorityControllerTest extends TestCase
{
    public function testIndex()
    {
        $item = factory('App\OrderPriority')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order_priorities');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $dbitems = OrderPriority::all();
        $response->seeJson($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1];
        $response = $this->actingAs($this->getAdminUser())->post('/order_priority',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = OrderPriority::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a'];
        $response = $this->actingAs($this->getAdminUser())->post('/order_priority',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE order_priorities CASCADE; --", 'notes' => "a'; DROP TABLE order_priorities CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/order_priority',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = OrderPriority::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order_priority',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = factory('App\OrderPriority')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order_priority/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
        $dbitem = OrderPriority::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/order_priority/a');
        $response->seeStatusCode(404);        
    }
    
    public function testUpdate()
    {
        $item = factory('App\OrderPriority')->create();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/order_priority/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = OrderPriority::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\OrderPriority')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/order_priority/' . $item->id);
        $response->seeStatusCode(204);
    }

    public function testAuth()
    {
        $response = $this->get('/order_priorities/');
        $response->seeStatusCode(401);
    }

}
