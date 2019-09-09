<?php

use App\Client;

class ClientControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = factory('App\Client', 2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/clients');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }
    
    public function testIndexWithActivityLevel()
    {
        $activity_levels = factory('App\ActivityLevel', 5)->create();
        $client0 = factory('App\Client')->create(['activity_level_id' => $activity_levels[0]->id]);
        $client1 = factory('App\Client')->create(['activity_level_id' => $activity_levels[4]->id]);
        $response = $this->actingAs($this->getAdminUser())->get('/clients?maximium_activity_level_id=' . $activity_levels[0]->id);
        $response->seeStatusCode(200);
        $response->seeJson($client0->toArray());
        $response->dontSeeJson(['name' => $client1->name]);
    }


    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = factory('App\Client')->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/client', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testRead()
    {
        $item = factory('App\Client')->create();
        $client = Client::first();
        $response = $this->actingAs($this->getAdminUser())->get('/client/' . $client->id);
        $response->seeStatusCode(200);
        $response->seeJson($client->toArray());
    }

    public function testUpdate()
    {
        $item = factory('App\Client')->create();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/client/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }
    
    public function testDelete()
    {
        $client = factory('App\Client')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/client/' . $client->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/clients');
        $response->seeStatusCode(401);
    }
}
