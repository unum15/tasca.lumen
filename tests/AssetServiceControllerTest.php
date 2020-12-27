<?php

use App\AssetService;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetServiceControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetService', 2)->create();
        $response = $this->get('/asset_services');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetService')->make();
        $response = $this->post('/asset_service', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_services', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetService')->create();
        $response = $this->get('/asset_service/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_services', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetService')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/asset_service/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_services', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetService')->create();
        $response = $this->delete('/asset_service/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_services', $item->toArray());
    }
}

