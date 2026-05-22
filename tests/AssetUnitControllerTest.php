<?php

use App\AssetUnit;

class AssetUnitControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetUnit::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_units');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetUnit::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_units', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_units', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetUnit::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_units', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_unit/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_units', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_units');
        $response->seeStatusCode(401);
    }
}
