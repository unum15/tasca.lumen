<?php

use App\AssetTimeUnit;

class AssetTimeUnitControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetTimeUnit::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_time_units');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetTimeUnit::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_time_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_time_units', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetTimeUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_time_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_time_units', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetTimeUnit::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_time_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_time_units', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetTimeUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_time_unit/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_time_units', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_time_units');
        $response->seeStatusCode(401);
    }
}
