<?php

use App\Contact;
use App\PhoneNumber;
use App\PhoneNumberType;

class PhoneNumberControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = factory('App\PhoneNumber', 2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/phone_numbers');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = factory('App\PhoneNumber')->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/phone_number', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testRead()
    {
        $item = factory('App\PhoneNumber')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }    

    public function testUpdate()
    {
        $item = factory('App\PhoneNumber')->create();
        $patch = ['phone_number' => '8005555555'];
        $response = $this->actingAs($this->getAdminUser())->patch('/phone_number/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }
    
    public function testDelete()
    {
        $item = factory('App\PhoneNumber')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/phone_number/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(401);
    }
}
