<?php

use App\AssetUnit;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetUnitControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetUnit', 2)->create();
        $response = $this->get('/asset_units');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetUnit')->make();
        $response = $this->post('/asset_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_units', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetUnit')->create();
        $response = $this->get('/asset_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_units', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetUnit')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_units', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetUnit')->create();
        $response = $this->delete('/asset_unit/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_units', $item->toArray());
    }
}

