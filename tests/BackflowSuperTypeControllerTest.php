<?php

use App\BackflowSuperType;

class BackflowSuperTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowSuperType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_super_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowSuperType::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_super_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_super_types', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowSuperType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_super_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_super_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowSuperType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_super_type/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_super_types', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowSuperType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_super_type/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_super_types', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_super_types');
        $response->seeStatusCode(401);
    }
}
