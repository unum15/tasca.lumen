<?php

use App\AssetRepair;

class AssetRepairControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetRepair::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_repairs');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetRepair::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_repair', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_repairs', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetRepair::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_repair/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_repairs', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetRepair::factory()->create();
        $update = ['where' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_repair/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_repairs', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetRepair::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_repair/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_repairs', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_repairs');
        $response->seeStatusCode(401);
    }
}
