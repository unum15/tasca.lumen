<?php

use App\IrrigationSystemOther;

class IrrigationSystemOtherControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = IrrigationSystemOther::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_system_others');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = IrrigationSystemOther::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/irrigation_system_other', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_system_others', $item->toArray());
    }

    public function testRead()
    {
        $item = IrrigationSystemOther::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_system_other/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_system_others', $item->toArray());
    }

    public function testUpdate()
    {
        $item = IrrigationSystemOther::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/irrigation_system_other/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_system_others', $updated_array);
    }

    public function testDelete()
    {
        $item = IrrigationSystemOther::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/irrigation_system_other/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_system_others', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/irrigation_system_others');
        $response->seeStatusCode(401);
    }
}
