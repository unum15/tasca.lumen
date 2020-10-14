<?php

use App\IrrigationSystem;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationSystemControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationSystem', 2)->create();
        $response = $this->get('/irrigation_systems');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationSystem')->make();
        $response = $this->post('/irrigation_system', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_systems', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationSystem')->create();
        $response = $this->get('/irrigation_system/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_systems', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationSystem')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_system/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_systems', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationSystem')->create();
        $response = $this->delete('/irrigation_system/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_systems', $item->toArray());
    }
}

