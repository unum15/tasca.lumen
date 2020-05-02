<?php

use App\OverheadAssignment;
use Laravel\Lumen\Testing\WithoutMiddleware;

class OverheadAssignmentControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\OverheadAssignment', 2)->create();
        $response = $this->get('/overhead_assignments');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\OverheadAssignment')->make();
        $response = $this->post('/overhead_assignment', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('overhead_assignments', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\OverheadAssignment')->create();
        $response = $this->get('/overhead_assignment/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('overhead_assignments', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\OverheadAssignment')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/overhead_assignment/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('overhead_assignments', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\OverheadAssignment')->create();
        $response = $this->delete('/overhead_assignment/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('overhead_assignments', $item->toArray());
    }
}

