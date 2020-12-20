<?php

use App\AssetAppraisal;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AssetAppraisalControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AssetAppraisal', 2)->create();
        $response = $this->get('/asset_appraisals');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AssetAppraisal')->make();
        $response = $this->post('/asset_appraisal', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('asset_appraisals', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AssetAppraisal')->create();
        $response = $this->get('/asset_appraisal/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('asset_appraisals', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AssetAppraisal')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/asset_appraisal/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('asset_appraisals', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AssetAppraisal')->create();
        $response = $this->delete('/asset_appraisal/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('asset_appraisals', $item->toArray());
    }
}

