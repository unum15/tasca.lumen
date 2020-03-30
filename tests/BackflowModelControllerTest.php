<?php

use App\BackflowModel;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowModelControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowModel', 2)->create();
        $response = $this->get('/backflow_models');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowModel')->make();
        $response = $this->post('/backflow_model', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_models', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowModel')->create();
        $response = $this->get('/backflow_model/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_models', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowModel')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_model/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_models', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowModel')->create();
        $response = $this->delete('/backflow_model/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_models', $item->toArray());
    }
}

