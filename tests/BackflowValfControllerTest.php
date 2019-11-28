<?php

use App\BackflowValf;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowValfControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowValf', 2)->create();
        $response = $this->get('/backflow_valves');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_valves', $items[0]->toArray());
        $this->seeInDatabase('backflow_valves', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowValf')->make();
        $response = $this->post('/backflow_valf', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowValf')->create();
        $response = $this->get('/backflow_valf/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowValf')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_valf/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_valves', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowValf')->create();
        $response = $this->delete('/backflow_valf/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_valves', $item->toArray());
    }
}

