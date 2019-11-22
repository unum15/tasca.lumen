<?php

use App\BackflowTypeValf;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowTypeValfControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowTypeValf', 2)->create();
        $response = $this->get('/backflow_type_valves');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_type_valves', $items[0]->toArray());
        $this->seeInDatabase('backflow_type_valves', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowTypeValf')->make();
        $response = $this->post('/backflow_type_valf', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_type_valves', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowTypeValf')->create();
        $response = $this->get('/backflow_type_valf/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_type_valves', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowTypeValf')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_type_valf/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_type_valves', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowTypeValf')->create();
        $response = $this->delete('/backflow_type_valf/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_type_valves', $item->toArray());
    }
}

