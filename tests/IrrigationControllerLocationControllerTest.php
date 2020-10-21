<?php

use App\IrrigationControllerLocation;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationControllerLocationControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationControllerLocation', 2)->create();
        $response = $this->get('/irrigation_controller_locations');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationControllerLocation')->make();
        $response = $this->post('/irrigation_controller_location', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_controller_locations', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationControllerLocation')->create();
        $response = $this->get('/irrigation_controller_location/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_controller_locations', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationControllerLocation')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_controller_location/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_controller_locations', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationControllerLocation')->create();
        $response = $this->delete('/irrigation_controller_location/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_controller_locations', $item->toArray());
    }
}

