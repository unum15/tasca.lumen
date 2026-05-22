<?php

use App\IrrigationWaterType;

class IrrigationWaterTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = IrrigationWaterType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_water_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = IrrigationWaterType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/irrigation_water_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_water_types', $item->toArray());
    }

    public function testRead()
    {
        $item = IrrigationWaterType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_water_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_water_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = IrrigationWaterType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/irrigation_water_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_water_types', $updated_array);
    }

    public function testDelete()
    {
        $item = IrrigationWaterType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/irrigation_water_type/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_water_types', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/irrigation_water_types');
        $response->seeStatusCode(401);
    }
}
