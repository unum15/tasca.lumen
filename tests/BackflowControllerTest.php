<?php

use App\Backflow;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Backflow', 2)->create();
        $response = $this->get('/backflows');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflows', $items[0]->toArray());
        $this->seeInDatabase('backflows', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Backflow')->make();
        $response = $this->post('/backflow', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflows', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Backflow')->create();
        $response = $this->get('/backflow/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflows', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Backflow')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflows', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Backflow')->create();
        $response = $this->delete('/backflow/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflows', $item->toArray());
    }
}

