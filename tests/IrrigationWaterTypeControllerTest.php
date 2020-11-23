<?php

use App\IrrigationWaterType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationWaterTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationWaterType', 2)->create();
        $response = $this->get('/irrigation_water_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationWaterType')->make();
        $response = $this->post('/irrigation_water_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_water_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationWaterType')->create();
        $response = $this->get('/irrigation_water_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_water_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationWaterType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_water_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_water_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationWaterType')->create();
        $response = $this->delete('/irrigation_water_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_water_types', $item->toArray());
    }
}

