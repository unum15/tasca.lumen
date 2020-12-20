<?php

use App\AssetLocation;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetLocationControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetLocation', 2)->create();
        $response = $this->get('/asset_locations');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetLocation')->make();
        $response = $this->post('/asset_location', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_locations', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetLocation')->create();
        $response = $this->get('/asset_location/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_locations', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetLocation')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_location/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_locations', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetLocation')->create();
        $response = $this->delete('/asset_location/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_locations', $item->toArray());
    }
}

