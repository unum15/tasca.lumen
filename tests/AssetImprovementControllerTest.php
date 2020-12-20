<?php

use App\AssetImprovement;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetImprovementControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetImprovement', 2)->create();
        $response = $this->get('/asset_improvements');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetImprovement')->make();
        $response = $this->post('/asset_improvement', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_improvements', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetImprovement')->create();
        $response = $this->get('/asset_improvement/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_improvements', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetImprovement')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_improvement/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_improvements', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetImprovement')->create();
        $response = $this->delete('/asset_improvement/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_improvements', $item->toArray());
    }
}

