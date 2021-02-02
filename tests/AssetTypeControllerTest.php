<?php

use App\AssetType;

class AssetTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetType::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/asset_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = AssetType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = AssetType::factory()->create();
        $update = ['number' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = AssetType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_types', $item->toArray());
    }
}

