<?php

use App\BackflowSize;

class BackflowSizeControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowSize::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_sizes');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowSize::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_size', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_sizes', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowSize::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_size/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_sizes', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowSize::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_size/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_sizes', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowSize::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_size/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_sizes', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_sizes');
        $response->seeStatusCode(401);
    }
}
