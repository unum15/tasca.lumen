<?php

use App\AssetFueling;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetFuelingControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetFueling', 2)->create();
        $response = $this->get('/asset_fuelings');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetFueling')->make();
        $response = $this->post('/asset_fueling', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_fuelings', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetFueling')->create();
        $response = $this->get('/asset_fueling/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_fuelings', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetFueling')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/asset_fueling/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_fuelings', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetFueling')->create();
        $response = $this->delete('/asset_fueling/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_fuelings', $item->toArray());
    }
}

