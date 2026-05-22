<?php

use App\Permission;

class PermissionControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = Permission::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/permissions');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = Permission::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/permission', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('permissions', $item->toArray());
    }

    public function testRead()
    {
        $item = Permission::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/permission/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }

    public function testUpdate()
    {
        $item = Permission::factory()->create();
        $update = ['name' => 'updated'];
        $response = $this->actingAs($this->getAdminUser())->patch('/permission/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $response->seeJsonEquals(['data' => array_merge($item->toArray(), $update)]);
        $this->seeInDatabase('permissions', array_merge($item->toArray(), $update));
    }

    public function testDelete()
    {
        $item = Permission::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/permission/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('permissions', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/permissions');
        $response->seeStatusCode(401);
    }
}
