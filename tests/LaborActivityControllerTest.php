<?php

use App\LaborActivity;

class LaborActivityControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = LaborActivity::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_activities');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = LaborActivity::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/labor_activity', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('labor_activities', $item->toArray());
    }
    
    public function testRead()
    {
        $item = LaborActivity::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_activity/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('labor_activities', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = LaborActivity::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/labor_activity/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('labor_activities', $updated_array);
    }
    
    public function testDelete()
    {
        $item = LaborActivity::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/labor_activity/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('labor_activities', $item->toArray());
    }
}

