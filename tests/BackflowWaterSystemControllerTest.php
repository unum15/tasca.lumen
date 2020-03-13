<?php

use App\BackflowWaterSystem;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowWaterSystemControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowWaterSystem', 2)->create();
        $response = $this->get('/backflow_water_systems');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_water_systems', $items[0]->toArray());
        $this->seeInDatabase('backflow_water_systems', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowWaterSystem')->make();
        $response = $this->post('/backflow_water_system', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_water_systems', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowWaterSystem')->create();
        $response = $this->get('/backflow_water_system/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_water_systems', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowWaterSystem')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_water_system/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_water_systems', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowWaterSystem')->create();
        $response = $this->delete('/backflow_water_system/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_water_systems', $item->toArray());
    }
}

