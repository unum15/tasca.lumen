<?php

use App\AssetGroup;

class AssetGroupControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetGroup::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_groups');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetGroup::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/asset_group', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_groups', $item->toArray());
    }
    
    public function testRead()
    {
        $item = AssetGroup::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_group/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_groups', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = AssetGroup::factory()->create();
        $update = ['sort_order' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_group/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_groups', $updated_array);
    }
    
    public function testDelete()
    {
        $item = AssetGroup::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_group/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_groups', $item->toArray());
    }
}

