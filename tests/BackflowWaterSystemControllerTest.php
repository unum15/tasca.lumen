<?php

use App\BackflowWaterSystem;

class BackflowWaterSystemControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowWaterSystem::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_water_systems');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_water_systems', $items[0]->toArray());
        $this->seeInDatabase('backflow_water_systems', $items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowWaterSystem::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_water_system', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_water_systems', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowWaterSystem::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_water_system/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_water_systems', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowWaterSystem::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_water_system/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_water_systems', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowWaterSystem::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_water_system/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_water_systems', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_water_systems');
        $response->seeStatusCode(401);
    }
}
