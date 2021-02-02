<?php

use App\AssetBrand;

class AssetBrandControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetBrand::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_brands');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = AssetBrand::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/asset_brand', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_brands', $item->toArray());
    }
    
    public function testRead()
    {
        $item = AssetBrand::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_brand/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_brands', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = AssetBrand::factory()->create();
        $update = ['sort_order' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_brand/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_brands', $updated_array);
    }
    
    public function testDelete()
    {
        $item = AssetBrand::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_brand/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_brands', $item->toArray());
    }
}

