<?php

use App\BackflowRepair;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowRepairControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowRepair', 2)->create();
        $response = $this->get('/backflow_repairs');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowRepair')->make();
        $response = $this->post('/backflow_repair', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_repairs', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowRepair')->create();
        $response = $this->get('/backflow_repair/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_repairs', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowRepair')->create();
        $update = ['repaired_on' => date('Y-m-d', strtotime('yesterday'))];
        $response = $this->patch('/backflow_repair/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_repairs', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowRepair')->create();
        $response = $this->delete('/backflow_repair/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_repairs', $item->toArray());
    }
}

