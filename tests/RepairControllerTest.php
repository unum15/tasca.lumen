<?php

use App\Repair;
use Laravel\Lumen\Testing\WithoutMiddleware;

class RepairControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Repair', 2)->create();
        $response = $this->get('/repairs');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Repair')->make();
        $response = $this->post('/repair', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('repairs', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Repair')->create();
        $response = $this->get('/repair/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }
    
    public function testUpdate()
    {
        $item = factory('App\Repair')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/repair/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('repairs', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Repair')->create();
        $response = $this->delete('/repair/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('repairs', $item->toArray());
    }
}

