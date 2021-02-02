<?php

use App\AssetSub;

class AssetSubControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetSub::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_subs');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetSub::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/asset_sub', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_subs', $item->toArray());
    }
    
    public function testRead()
    {
        $item = AssetSub::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_sub/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_subs', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = AssetSub::factory()->create();
        $update = ['sort_order' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_sub/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_subs', $updated_array);
    }
    
    public function testDelete()
    {
        $item = AssetSub::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_sub/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_subs', $item->toArray());
    }
}

