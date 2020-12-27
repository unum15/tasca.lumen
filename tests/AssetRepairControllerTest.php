<?php

use App\AssetRepair;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetRepairControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetRepair', 2)->create();
        $response = $this->get('/asset_repairs');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetRepair')->make();
        $response = $this->post('/asset_repair', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_repairs', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetRepair')->create();
        $response = $this->get('/asset_repair/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_repairs', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetRepair')->create();
        $update = ['where' => 'test'];
        $response = $this->patch('/asset_repair/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_repairs', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetRepair')->create();
        $response = $this->delete('/asset_repair/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_repairs', $item->toArray());
    }
}

