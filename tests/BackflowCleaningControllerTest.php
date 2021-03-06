<?php

use App\BackflowCleaning;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowCleaningControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowCleaning', 2)->create();
        $response = $this->get('/backflow_cleanings');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowCleaning')->make();
        $response = $this->post('/backflow_cleaning', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_cleanings', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowCleaning')->create();
        $response = $this->get('/backflow_cleaning/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_cleanings', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowCleaning')->create();
        $update = ['cleaned_on' => date('Y-m-d', strtotime('yesterday'))];
        $response = $this->patch('/backflow_cleaning/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_cleanings', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowCleaning')->create();
        $response = $this->delete('/backflow_cleaning/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_cleanings', $item->toArray());
    }
}

