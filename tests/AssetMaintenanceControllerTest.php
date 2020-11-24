<?php

use App\AssetMaintenance;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetMaintenanceControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetMaintenance', 2)->create();
        $response = $this->get('/asset_maintenances');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetMaintenance')->make();
        $response = $this->post('/asset_maintenance', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_maintenances', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetMaintenance')->create();
        $response = $this->get('/asset_maintenance/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_maintenances', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetMaintenance')->create();
        $update = ['where' => 'test'];
        $response = $this->patch('/asset_maintenance/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_maintenances', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetMaintenance')->create();
        $response = $this->delete('/asset_maintenance/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_maintenances', $item->toArray());
    }
}

