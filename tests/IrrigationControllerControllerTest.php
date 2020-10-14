<?php

use App\IrrigationController;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationControllerControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationController', 2)->create();
        $response = $this->get('/irrigation_controllers');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationController')->make();
        $response = $this->post('/irrigation_controller', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_controllers', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationController')->create();
        $response = $this->get('/irrigation_controller/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_controllers', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationController')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_controller/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_controllers', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationController')->create();
        $response = $this->delete('/irrigation_controller/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_controllers', $item->toArray());
    }
}

