<?php

use App\BackflowsAssembly;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowsAssemblyControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowsAssembly', 2)->create();
        $response = $this->get('/backflows_assemblies');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflows_assemblies', $items[0]->toArray());
        $this->seeInDatabase('backflows_assemblies', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowsAssembly')->make();
        $response = $this->post('/backflows_assembly', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflows_assemblies', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowsAssembly')->create();
        $response = $this->get('/backflows_assembly/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflows_assemblies', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowsAssembly')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflows_assembly/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflows_assemblies', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowsAssembly')->create();
        $response = $this->delete('/backflows_assembly/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflows_assemblies', $item->toArray());
    }
}

