<?php

use App\AssetMaintenance;

class AssetMaintenanceControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetMaintenance::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_maintenances');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetMaintenance::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_maintenance', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_maintenances', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetMaintenance::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_maintenance/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_maintenances', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetMaintenance::factory()->create();
        $update = ['where' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_maintenance/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_maintenances', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetMaintenance::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_maintenance/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_maintenances', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_maintenances');
        $response->seeStatusCode(401);
    }
}
