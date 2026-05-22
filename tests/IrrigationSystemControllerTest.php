<?php

use App\IrrigationSystem;

class IrrigationSystemControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = IrrigationSystem::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_systems');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = IrrigationSystem::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/irrigation_system', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_systems', $item->toArray());
    }

    public function testRead()
    {
        $item = IrrigationSystem::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_system/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_systems', $item->toArray());
    }

    public function testUpdate()
    {
        $item = IrrigationSystem::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/irrigation_system/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_systems', $updated_array);
    }

    public function testDelete()
    {
        $item = IrrigationSystem::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/irrigation_system/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_systems', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/irrigation_systems');
        $response->seeStatusCode(401);
    }
}
