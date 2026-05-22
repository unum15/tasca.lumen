<?php

use App\AssetImprovement;

class AssetImprovementControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetImprovement::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_improvements');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetImprovement::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_improvement', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_improvements', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetImprovement::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_improvement/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_improvements', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetImprovement::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_improvement/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_improvements', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetImprovement::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_improvement/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_improvements', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_improvements');
        $response->seeStatusCode(401);
    }
}
