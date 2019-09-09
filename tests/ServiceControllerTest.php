<?php

use App\Service;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ServiceControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Service', 2)->create();
        $response = $this->get('/services');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Service')->make();
        $response = $this->post('/service', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('services', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Service')->create();
        $response = $this->get('/service/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('services', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Service')->create();
        $update = ['description' => 'test'];
        $response = $this->patch('/service/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('services', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Service')->create();
        $response = $this->delete('/service/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('services', $item->toArray());
    }
}

