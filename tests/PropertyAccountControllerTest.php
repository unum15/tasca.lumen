<?php

use App\PropertyAccount;

class PropertyAccountControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = PropertyAccount::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/property_accounts');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = PropertyAccount::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/property_account', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('property_accounts', $item->toArray());
    }

    public function testRead()
    {
        $item = PropertyAccount::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/property_account/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('property_accounts', $item->toArray());
    }

    public function testUpdate()
    {
        $item = PropertyAccount::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/property_account/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('property_accounts', $updated_array);
    }

    public function testDelete()
    {
        $item = PropertyAccount::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/property_account/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('property_accounts', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/property_accounts');
        $response->seeStatusCode(401);
    }
}
