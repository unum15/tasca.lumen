<?php

use App\Asset;

class AssetControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = Asset::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/assets');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = Asset::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('assets', $item->toArray());
    }

    public function testRead()
    {
        $item = Asset::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('assets', $item->toArray());
    }

    public function testUpdate()
    {
        $item = Asset::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('assets', $updated_array);
    }

    public function testDelete()
    {
        $item = Asset::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('assets', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/assets');
        $response->seeStatusCode(401);
    }
}
