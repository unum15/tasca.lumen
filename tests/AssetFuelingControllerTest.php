<?php

use App\AssetFueling;

class AssetFuelingControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetFueling::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_fuelings');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetFueling::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_fueling', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_fuelings', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetFueling::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_fueling/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_fuelings', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetFueling::factory()->create();
        $update = ['notes' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_fueling/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_fuelings', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetFueling::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_fueling/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_fuelings', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_fuelings');
        $response->seeStatusCode(401);
    }
}
