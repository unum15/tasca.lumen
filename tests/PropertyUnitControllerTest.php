<?php

use App\PropertyUnit;

class PropertyUnitControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = PropertyUnit::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/property_units');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = PropertyUnit::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/property_unit', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('property_units', $item->toArray());
    }

    public function testRead()
    {
        $item = PropertyUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/property_unit/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('property_units', $item->toArray());
    }

    public function testUpdate()
    {
        $item = PropertyUnit::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/property_unit/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('property_units', $updated_array);
    }

    public function testDelete()
    {
        $item = PropertyUnit::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/property_unit/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('property_units', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/property_units');
        $response->seeStatusCode(401);
    }
}
