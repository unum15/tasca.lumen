<?php

use App\BackflowType;

class BackflowTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_types');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_types', $items[0]->toArray());
        $this->seeInDatabase('backflow_types', $items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_types', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_types', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_types', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_types');
        $response->seeStatusCode(401);
    }
}
