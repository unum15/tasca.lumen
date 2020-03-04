<?php

use App\UsageType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class UsageTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\UsageType', 2)->create();
        $response = $this->get('/usage_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\UsageType')->make();
        $response = $this->post('/usage_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('usage_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\UsageType')->create();
        $response = $this->get('/usage_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('usage_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\UsageType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/usage_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('usage_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\UsageType')->create();
        $response = $this->delete('/usage_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('usage_types', $item->toArray());
    }
}

