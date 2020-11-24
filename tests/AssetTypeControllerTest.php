<?php

use App\AssetType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetType', 2)->create();
        $response = $this->get('/asset_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetType')->make();
        $response = $this->post('/asset_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetType')->create();
        $response = $this->get('/asset_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetType')->create();
        $response = $this->delete('/asset_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_types', $item->toArray());
    }
}

