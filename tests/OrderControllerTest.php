<?php

use App\Order;

class OrderControllerTest extends TestCase
{

    public function testIndex()
    {
        $item = factory('App\Order')->create();
        $item = factory('App\Order')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/orders');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testCreate()
    {
        $project = factory(App\Project::class)->create();
        $item = [
            'name' => 'Test ServiceOrder',
            'project_id' => $project->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Order::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateFull()
    {
        $project = factory(App\Project::class)->create();
        $item = [
            'name' => 'Test ServiceOrder',
            'project_id' => $project->id,
            'notes' => 'foo'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Order::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    public function testCreateBad()
    {
        $item = [
            'name' => ''
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $project = factory(App\Project::class)->create();
        $item = [
            'name' => "a'; DROP TABLE service_orders CASCADE; --",
            'project_id' => $project->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Order::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $project = factory(App\Project::class)->create();
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'project_id' => $project->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = factory('App\Order')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $dbitem = Order::find($item->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/order/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = factory('App\Order')->create();
        $patch = ['name' => 'Test ServiceOrder 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/order/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Order::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\Order')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/order/' . $item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    public function testAuth()
    {
        $response = $this->get('/orders');
        $response->seeStatusCode(401);
    }
}
