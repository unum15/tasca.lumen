<?php

use App\AssetCategory;

class AssetCategoryControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetCategory::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_categories');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetCategory::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/asset_category', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_categories', $item->toArray());
    }
    
    public function testRead()
    {
        $item = AssetCategory::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_category/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_categories', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = AssetCategory::factory()->create();
        $update = ['sort_order' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_category/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_categories', $updated_array);
    }
    
    public function testDelete()
    {
        $item = AssetCategory::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_category/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_categories', $item->toArray());
    }
}

