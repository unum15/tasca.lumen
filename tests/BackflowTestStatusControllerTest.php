<?php

use App\BackflowTestStatus;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowTestStatusControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowTestStatus', 2)->create();
        $response = $this->get('/backflow_test_statuses');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_test_statuses', $items[0]->toArray());
        $this->seeInDatabase('backflow_test_statuses', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowTestStatus')->make();
        $response = $this->post('/backflow_test_status', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_test_statuses', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowTestStatus')->create();
        $response = $this->get('/backflow_test_status/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_test_statuses', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowTestStatus')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_test_status/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_test_statuses', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowTestStatus')->create();
        $response = $this->delete('/backflow_test_status/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_test_statuses', $item->toArray());
    }
}

