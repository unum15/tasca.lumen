<?php

use App\BackflowValve;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowValveControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowValve', 2)->create();
        $response = $this->get('/backflow_valves');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowValve')->make();
        $response = $this->post('/backflow_valve', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowValve')->create();
        $response = $this->get('/backflow_valve/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowValve')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_valve/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_valves', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowValve')->create();
        $response = $this->delete('/backflow_valve/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_valves', $item->toArray());
    }
}

