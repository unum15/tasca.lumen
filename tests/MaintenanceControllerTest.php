<?php

use App\Maintenance;
use Laravel\Lumen\Testing\WithoutMiddleware;

class MaintenanceControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Maintenance', 2)->create();
        $response = $this->get('/maintenances');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Maintenance')->make();
        $response = $this->post('/maintenance', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('maintenances', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Maintenance')->create();
        $response = $this->get('/maintenance/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }
    
    public function testUpdate()
    {
        $item = factory('App\Maintenance')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/maintenance/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('maintenances', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Maintenance')->create();
        $response = $this->delete('/maintenance/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('maintenances', $item->toArray());
    }
}

