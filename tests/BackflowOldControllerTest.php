<?php

use App\BackflowOld;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowOldControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowOld', 2)->create();
        $response = $this->get('/backflow_old');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_old', $items[0]->toArray());
        $this->seeInDatabase('backflow_old', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowOld')->make();
        $response = $this->post('/backflow_old', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_old', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowOld')->create();
        $response = $this->get('/backflow_old/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_old', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowOld')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_old/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_old', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowOld')->create();
        $response = $this->delete('/backflow_old/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_old', $item->toArray());
    }
}

