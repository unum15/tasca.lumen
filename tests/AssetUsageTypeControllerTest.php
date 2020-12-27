<?php

use App\AssetUsageType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetUsageTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetUsageType', 2)->create();
        $response = $this->get('/asset_usage_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetUsageType')->make();
        $response = $this->post('/asset_usage_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_usage_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetUsageType')->create();
        $response = $this->get('/asset_usage_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_usage_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetUsageType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_usage_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_usage_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetUsageType')->create();
        $response = $this->delete('/asset_usage_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_usage_types', $item->toArray());
    }
}

