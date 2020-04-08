<?php

use App\BackflowAssembly;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowAssemblyControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowAssembly', 2)->create();
        $response = $this->get('/backflow_assemblies');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowAssembly')->make();
        $response = $this->post('/backflow_assembly', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_assemblies', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowAssembly')->create();
        $response = $this->get('/backflow_assembly/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_assemblies', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowAssembly')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/backflow_assembly/' . $item->id, $update);
        $response->seeStatusCode(200);
        $update['updated_at'] = date('Y-m-d H:i:s',strtotime(BackflowAssembly::find($item->id)['updated_at']));
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_assemblies', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowAssembly')->create();
        $response = $this->delete('/backflow_assembly/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_assemblies', $item->toArray());
    }
}

