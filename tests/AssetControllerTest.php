<?php

use App\Asset;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Asset', 2)->create();
        $response = $this->get('/assets');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Asset')->make();
        $response = $this->post('/asset', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('assets', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Asset')->create();
        $response = $this->get('/asset/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('assets', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Asset')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('assets', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Asset')->create();
        $response = $this->delete('/asset/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('assets', $item->toArray());
    }
}

