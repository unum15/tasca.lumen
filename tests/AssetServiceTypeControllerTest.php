<?php

use App\AssetServiceType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetServiceTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetServiceType', 2)->create();
        $response = $this->get('/asset_service_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetServiceType')->make();
        $response = $this->post('/asset_service_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_service_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetServiceType')->create();
        $response = $this->get('/asset_service_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_service_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetServiceType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_service_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_service_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetServiceType')->create();
        $response = $this->delete('/asset_service_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_service_types', $item->toArray());
    }
}

