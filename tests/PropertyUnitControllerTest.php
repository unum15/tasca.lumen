<?php

use App\PropertyUnit;
use Laravel\Lumen\Testing\WithoutMiddleware;

class PropertyUnitControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\PropertyUnit', 2)->create();
        $response = $this->get('/property_units');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('property_units', $items[0]->toArray());
        $this->seeInDatabase('property_units', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\PropertyUnit')->make();
        $response = $this->post('/property_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('property_units', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\PropertyUnit')->create();
        $response = $this->get('/property_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('property_units', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\PropertyUnit')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/property_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('property_units', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\PropertyUnit')->create();
        $response = $this->delete('/property_unit/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('property_units', $item->toArray());
    }
}

