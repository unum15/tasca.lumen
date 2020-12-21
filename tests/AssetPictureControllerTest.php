<?php

use App\AssetPicture;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetPictureControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetPicture', 2)->create();
        $response = $this->get('/asset_pictures');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetPicture')->make();
        $response = $this->post('/asset_picture', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_pictures', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetPicture')->create();
        $response = $this->get('/asset_picture/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_pictures', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetPicture')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_picture/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_pictures', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetPicture')->create();
        $response = $this->delete('/asset_picture/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_pictures', $item->toArray());
    }
}

