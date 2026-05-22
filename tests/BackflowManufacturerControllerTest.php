<?php

use App\BackflowManufacturer;

class BackflowManufacturerControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowManufacturer::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_manufacturers');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowManufacturer::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_manufacturer', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_manufacturers', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowManufacturer::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_manufacturer/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_manufacturers', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowManufacturer::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_manufacturer/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_manufacturers', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowManufacturer::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_manufacturer/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_manufacturers', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_manufacturers');
        $response->seeStatusCode(401);
    }
}
