<?php

use App\ServiceType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ServiceTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\ServiceType', 2)->create();
        $response = $this->get('/service_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\ServiceType')->make();
        $response = $this->post('/service_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('service_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\ServiceType')->create();
        $response = $this->get('/service_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }
    
    public function testUpdate()
    {
        $item = factory('App\ServiceType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/service_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('service_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\ServiceType')->create();
        $response = $this->delete('/service_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('service_types', $item->toArray());
    }
}
