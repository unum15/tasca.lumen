<?php

use App\VehicleType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class VehicleTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\VehicleType', 2)->create();
        $response = $this->get('/vehicle_types');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('vehicle_types', $items[0]->toArray());
        $this->seeInDatabase('vehicle_types', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\VehicleType')->make();
        $response = $this->post('/vehicle_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('vehicle_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\VehicleType')->create();
        $response = $this->get('/vehicle_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('vehicle_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\VehicleType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/vehicle_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('vehicle_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\VehicleType')->create();
        $response = $this->delete('/vehicle_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('vehicle_types', $item->toArray());
    }
}

