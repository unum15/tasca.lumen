<?php

use App\BackflowType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowType', 2)->create();
        $response = $this->get('/backflow_types');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_types', $items[0]->toArray());
        $this->seeInDatabase('backflow_types', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowType')->make();
        $response = $this->post('/backflow_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowType')->create();
        $response = $this->get('/backflow_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowType')->create();
        $response = $this->delete('/backflow_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_types', $item->toArray());
    }
}

