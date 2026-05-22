<?php

use App\AssetServiceType;

class AssetServiceTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetServiceType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_service_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetServiceType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_service_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_service_types', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetServiceType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_service_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_service_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetServiceType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_service_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_service_types', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetServiceType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_service_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_service_types', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_service_types');
        $response->seeStatusCode(401);
    }
}
