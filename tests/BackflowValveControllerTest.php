<?php

use App\BackflowValve;

class BackflowValveControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowValve::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_valves');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowValve::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_valve', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowValve::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_valve/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_valves', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowValve::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_valve/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_valves', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowValve::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_valve/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_valves', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_valves');
        $response->seeStatusCode(401);
    }
}
