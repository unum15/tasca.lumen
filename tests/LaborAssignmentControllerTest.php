<?php

use App\LaborAssignment;

class LaborAssignmentControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = LaborAssignment::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_assignments');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = LaborAssignment::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/labor_assignment', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('labor_assignments', $item->toArray());
    }
    
    public function testRead()
    {
        $item = LaborAssignment::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_assignment/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('labor_assignments', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = LaborAssignment::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/labor_assignment/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('labor_assignments', $updated_array);
    }
    
    public function testDelete()
    {
        $item = LaborAssignment::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/labor_assignment/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('labor_assignments', $item->toArray());
    }
}

