<?php

use App\AssetUsageType;

class AssetUsageTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetUsageType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_usage_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetUsageType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_usage_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_usage_types', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetUsageType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_usage_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_usage_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetUsageType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_usage_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_usage_types', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetUsageType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_usage_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_usage_types', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_usage_types');
        $response->seeStatusCode(401);
    }
}
