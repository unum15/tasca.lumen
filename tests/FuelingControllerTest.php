<?php

use App\Fueling;
use Laravel\Lumen\Testing\WithoutMiddleware;

class FuelingControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Fueling', 2)->create();
        $response = $this->get('/fuelings');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Fueling')->make();
        $response = $this->post('/fueling', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('fuelings', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Fueling')->create();
        $response = $this->get('/fueling/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }
    
    public function testUpdate()
    {
        $item = factory('App\Fueling')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/fueling/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('fuelings', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Fueling')->create();
        $response = $this->delete('/fueling/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('fuelings', $item->toArray());
    }
}
