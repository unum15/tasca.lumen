<?php

use App\AssetAccessory;

class AssetAccessoryControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = AssetAccessory::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_accessories');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetAccessory::factory(['creator_id' => $user->id, 'updater_id' => $user->id])->make();
        $response = $this->actingAs($user)->post('/asset_accessory', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_accessories', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetAccessory::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_accessory/'.$item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_accessories', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetAccessory::factory()->create();
        $update = ['notes' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_accessory/'.$item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_accessories', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetAccessory::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_accessory/'.$item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_accessories', $item->toArray());
    }
}
