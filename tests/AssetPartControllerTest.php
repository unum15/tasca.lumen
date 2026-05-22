<?php

use App\AssetPart;

class AssetPartControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetPart::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_parts');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetPart::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_part', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_parts', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetPart::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_part/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_parts', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetPart::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_part/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_parts', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetPart::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_part/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_parts', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_parts');
        $response->seeStatusCode(401);
    }
}
