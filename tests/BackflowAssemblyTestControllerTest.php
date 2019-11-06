<?php

use App\BackflowAssemblyTest;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowAssemblyTestControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowAssemblyTest', 2)->create();
        $response = $this->get('/backflow_assembly_tests');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_assembly_tests', $items[0]->toArray());
        $this->seeInDatabase('backflow_assembly_tests', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowAssemblyTest')->make();
        $response = $this->post('/backflow_assembly_test', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_assembly_tests', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowAssemblyTest')->create();
        $response = $this->get('/backflow_assembly_test/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_assembly_tests', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowAssemblyTest')->create();
        $update = ['visual_inspection_notes' => 'test'];
        $response = $this->patch('/backflow_assembly_test/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_assembly_tests', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowAssemblyTest')->create();
        $response = $this->delete('/backflow_assembly_test/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_assembly_tests', $item->toArray());
    }
}

