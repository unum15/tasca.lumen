<?php

use App\BackflowManufacturer;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowManufacturerControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowManufacturer', 2)->create();
        $response = $this->get('/backflow_manufacturers');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowManufacturer')->make();
        $response = $this->post('/backflow_manufacturer', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_manufacturers', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowManufacturer')->create();
        $response = $this->get('/backflow_manufacturer/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_manufacturers', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowManufacturer')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_manufacturer/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_manufacturers', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowManufacturer')->create();
        $response = $this->delete('/backflow_manufacturer/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_manufacturers', $item->toArray());
    }
}

