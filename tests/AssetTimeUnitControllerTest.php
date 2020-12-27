<?php

use App\AssetTimeUnit;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetTimeUnitControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetTimeUnit', 2)->create();
        $response = $this->get('/asset_time_units');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetTimeUnit')->make();
        $response = $this->post('/asset_time_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_time_units', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetTimeUnit')->create();
        $response = $this->get('/asset_time_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_time_units', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetTimeUnit')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_time_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_time_units', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetTimeUnit')->create();
        $response = $this->delete('/asset_time_unit/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_time_units', $item->toArray());
    }
}

