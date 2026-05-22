<?php

use App\AssetAppraisal;

class AssetAppraisalControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetAppraisal::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_appraisals');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetAppraisal::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_appraisal', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_appraisals', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetAppraisal::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_appraisal/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_appraisals', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetAppraisal::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_appraisal/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_appraisals', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetAppraisal::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_appraisal/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_appraisals', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_appraisals');
        $response->seeStatusCode(401);
    }
}
