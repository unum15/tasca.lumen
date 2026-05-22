<?php

use App\BackflowValvePart;

class BackflowValvePartControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowValvePart::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_valve_parts');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_valve_parts', $items[0]->toArray());
        $this->seeInDatabase('backflow_valve_parts', $items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowValvePart::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_valve_part', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_valve_parts', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowValvePart::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_valve_part/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_valve_parts', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowValvePart::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_valve_part/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_valve_parts', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowValvePart::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_valve_part/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_valve_parts', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_valve_parts');
        $response->seeStatusCode(401);
    }
}
