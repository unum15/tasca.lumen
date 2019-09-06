<?php

use App\BackflowStyle;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowStyleControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowStyle', 2)->create();
        $response = $this->get('/backflow_styles');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_styles', $items[0]->toArray());
        $this->seeInDatabase('backflow_styles', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowStyle')->make();
        $response = $this->post('/backflow_style', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_styles', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowStyle')->create();
        $response = $this->get('/backflow_style/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_styles', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowStyle')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_style/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_styles', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowStyle')->create();
        $response = $this->delete('/backflow_style/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_styles', $item->toArray());
    }
}

