<?php

use App\BackflowTest;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowTestControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowTest', 2)->create();
        $response = $this->get('/backflow_tests');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_tests', $items[0]->toArray());
        $this->seeInDatabase('backflow_tests', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowTest')->make();
        $response = $this->post('/backflow_test', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_tests', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowTest')->create();
        $response = $this->get('/backflow_test/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_tests', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowTest')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/backflow_test/' . $item->id, $update);
        $response->seeStatusCode(200);
        $update['updated_at'] = date('Y-m-d H:i:s',strtotime(BackflowTest::find($item->id)['updated_at']));
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_tests', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowTest')->create();
        $response = $this->delete('/backflow_test/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('backflow_tests', $item->toArray());
    }
}

