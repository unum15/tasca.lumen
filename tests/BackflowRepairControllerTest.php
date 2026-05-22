<?php

use App\BackflowRepair;

class BackflowRepairControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowRepair::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_repairs');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowRepair::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_repair', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_repairs', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowRepair::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_repair/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_repairs', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowRepair::factory()->create();
        $update = ['repaired_on' => date('Y-m-d', strtotime('yesterday'))];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_repair/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_repairs', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowRepair::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_repair/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_repairs', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_repairs');
        $response->seeStatusCode(401);
    }
}
