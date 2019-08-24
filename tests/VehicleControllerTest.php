<?php

use App\Vehicle;
use Laravel\Lumen\Testing\WithoutMiddleware;

class VehicleControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Vehicle', 2)->create();
        $response = $this->get('/vehicles');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('vehicles', $items[0]->toArray());
        $this->seeInDatabase('vehicles', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Vehicle')->make();
        $response = $this->post('/vehicle', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('vehicles', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Vehicle')->create();
        $response = $this->get('/vehicle/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('vehicles', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Vehicle')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/vehicle/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('vehicles', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Vehicle')->create();
        $response = $this->delete('/vehicle/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('vehicles', $item->toArray());
    }
}

