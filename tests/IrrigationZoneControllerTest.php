<?php

use App\IrrigationZone;
use Laravel\Lumen\Testing\WithoutMiddleware;

class IrrigationZoneControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\IrrigationZone', 2)->create();
        $response = $this->get('/irrigation_zones');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\IrrigationZone')->make();
        $response = $this->post('/irrigation_zone', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_zones', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\IrrigationZone')->create();
        $response = $this->get('/irrigation_zone/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_zones', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\IrrigationZone')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/irrigation_zone/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_zones', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\IrrigationZone')->create();
        $response = $this->delete('/irrigation_zone/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_zones', $item->toArray());
    }
}

