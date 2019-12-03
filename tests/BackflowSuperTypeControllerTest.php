<?php

use App\BackflowSuperType;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowSuperTypeControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowSuperType', 2)->create();
        $response = $this->get('/backflow_super_types');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_super_types', $items[0]->toArray());
        $this->seeInDatabase('backflow_super_types', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowSuperType')->make();
        $response = $this->post('/backflow_super_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_super_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowSuperType')->create();
        $response = $this->get('/backflow_super_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_super_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowSuperType')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_super_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_super_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowSuperType')->create();
        $response = $this->delete('/backflow_super_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_super_types', $item->toArray());
    }
}

