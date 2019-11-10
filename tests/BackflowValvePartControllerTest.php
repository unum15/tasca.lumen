<?php

use App\BackflowValvePart;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowValvePartControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowValvePart', 2)->create();
        $response = $this->get('/backflow_valve_parts');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_valve_parts', $items[0]->toArray());
        $this->seeInDatabase('backflow_valve_parts', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowValvePart')->make();
        $response = $this->post('/backflow_valve_part', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_valve_parts', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowValvePart')->create();
        $response = $this->get('/backflow_valve_part/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_valve_parts', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowValvePart')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_valve_part/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_valve_parts', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowValvePart')->create();
        $response = $this->delete('/backflow_valve_part/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_valve_parts', $item->toArray());
    }
}

