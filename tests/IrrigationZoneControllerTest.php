<?php

use App\IrrigationZone;

class IrrigationZoneControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = IrrigationZone::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_zones');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = IrrigationZone::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/irrigation_zone', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('irrigation_zones', $item->toArray());
    }

    public function testRead()
    {
        $item = IrrigationZone::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/irrigation_zone/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('irrigation_zones', $item->toArray());
    }

    public function testUpdate()
    {
        $item = IrrigationZone::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/irrigation_zone/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('irrigation_zones', $updated_array);
    }

    public function testDelete()
    {
        $item = IrrigationZone::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/irrigation_zone/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('irrigation_zones', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/irrigation_zones');
        $response->seeStatusCode(401);
    }
}
