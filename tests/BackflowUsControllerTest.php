<?php

use App\BackflowUs;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowUsControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowUs', 2)->create();
        $response = $this->get('/backflow_uses');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_uses', $items[0]->toArray());
        $this->seeInDatabase('backflow_uses', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowUs')->make();
        $response = $this->post('/backflow_us', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_uses', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowUs')->create();
        $response = $this->get('/backflow_us/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_uses', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowUs')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_us/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_uses', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowUs')->create();
        $response = $this->delete('/backflow_us/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_uses', $item->toArray());
    }
}

