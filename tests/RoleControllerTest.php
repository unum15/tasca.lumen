<?php

use App\Role;
use App\Permission;

class RoleControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = Role::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/roles');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = Role::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/role', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('roles', $item->toArray());
    }

    public function testRead()
    {
        $item = Role::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/role/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
    }

    public function testUpdate()
    {
        $item = Role::factory()->create();
        $update = ['name' => 'updated'];
        $response = $this->actingAs($this->getAdminUser())->patch('/role/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $response->seeJsonEquals(['data' => array_merge($item->toArray(), $update)]);
        $this->seeInDatabase('roles', array_merge($item->toArray(), $update));
    }

    public function testUpdatePermissions()
    {
        $item = Role::factory()->create();
        $perm1 = Permission::factory()->create();
        $perm2 = Permission::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->put('/role/' . $item->id . '/permissions', [
            'permissions' => [$perm1->id, $perm2->id]
        ]);
        $response->seeStatusCode(200);
        $this->seeInDatabase('permission_role', ['role_id' => $item->id, 'permission_id' => $perm1->id]);
        $this->seeInDatabase('permission_role', ['role_id' => $item->id, 'permission_id' => $perm2->id]);
    }

    public function testDelete()
    {
        $item = Role::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/role/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('roles', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/roles');
        $response->seeStatusCode(401);
    }
}
