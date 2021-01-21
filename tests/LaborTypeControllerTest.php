<?php

use App\LaborType;

class LaborTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = LaborType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = LaborType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/labor_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('labor_types', $item->toArray());
    }
    
    public function testRead()
    {
        $item = LaborType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/labor_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('labor_types', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = LaborType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/labor_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('labor_types', $updated_array);
    }
    
    public function testDelete()
    {
        $item = LaborType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/labor_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('labor_types', $item->toArray());
    }
}

