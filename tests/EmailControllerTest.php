<?php

use App\Contact;
use App\Email;
use App\EmailType;

class EmailControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = factory('App\Email', 2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/emails');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }
    
    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = factory('App\Email')->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/email', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testRead()
    {
        $item = factory('App\Email')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/email/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testUpdate()
    {
        $item = factory('App\Email')->create();
        $patch = ['email' => 'Test2@test.com'];
        $response = $this->actingAs($this->getAdminUser())->patch('/email/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }
    
    public function testDelete()
    {
        $item = factory('App\Email')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/email/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/emails');
        $response->seeStatusCode(401);
    }
}
