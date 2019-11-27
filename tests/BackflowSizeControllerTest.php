<?php

use App\BackflowSize;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowSizeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowSize', 2)->create();
        $response = $this->get('/backflow_sizes');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_sizes', $items[0]->toArray());
        $this->seeInDatabase('backflow_sizes', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowSize')->make();
        $response = $this->post('/backflow_size', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_sizes', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowSize')->create();
        $response = $this->get('/backflow_size/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_sizes', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowSize')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_size/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_sizes', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowSize')->create();
        $response = $this->delete('/backflow_size/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_sizes', $item->toArray());
    }
}

