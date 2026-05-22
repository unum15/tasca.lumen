<?php

use App\BackflowModel;

class BackflowModelControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowModel::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_models');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowModel::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_model', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_models', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowModel::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_model/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_models', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowModel::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_model/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_models', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowModel::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_model/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_models', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_models');
        $response->seeStatusCode(401);
    }
}
