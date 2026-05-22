<?php

use App\AssetPicture;

class AssetPictureControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = AssetPicture::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_pictures');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = AssetPicture::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/asset_picture', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_pictures', $item->toArray());
    }

    public function testRead()
    {
        $item = AssetPicture::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/asset_picture/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_pictures', $item->toArray());
    }

    public function testUpdate()
    {
        $item = AssetPicture::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/asset_picture/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_pictures', $updated_array);
    }

    public function testDelete()
    {
        $item = AssetPicture::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/asset_picture/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_pictures', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/asset_pictures');
        $response->seeStatusCode(401);
    }
}
