<?php

use App\AssetPart;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetPartControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetPart', 2)->create();
        $response = $this->get('/asset_parts');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetPart')->make();
        $response = $this->post('/asset_part', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_parts', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetPart')->create();
        $response = $this->get('/asset_part/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_parts', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetPart')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_part/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_parts', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetPart')->create();
        $response = $this->delete('/asset_part/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_parts', $item->toArray());
    }
}

