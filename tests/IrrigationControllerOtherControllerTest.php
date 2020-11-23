<?php

use App\IrrigationControllerOther;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationControllerOtherControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationControllerOther', 2)->create();
        $response = $this->get('/irrigation_controller_others');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationControllerOther')->make();
        $response = $this->post('/irrigation_controller_other', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_controller_others', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationControllerOther')->create();
        $response = $this->get('/irrigation_controller_other/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_controller_others', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationControllerOther')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_controller_other/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_controller_others', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationControllerOther')->create();
        $response = $this->delete('/irrigation_controller_other/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_controller_others', $item->toArray());
    }
}

