<?php

use App\ActivityLevel;
use App\Client;

class ClientControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = Client::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/clients');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testIndexWithActivityLevel()
    {
        $activity_levels = ActivityLevel::factory(5)->create();
        $client0 = Client::factory()->create(['activity_level_id' => $activity_levels[0]->id]);
        $client1 = Client::factory()->create(['activity_level_id' => $activity_levels[4]->id]);
        $response = $this->actingAs($this->getAdminUser())->get('/clients?maximium_activity_level_id=' . $activity_levels[0]->id);
        $response->seeStatusCode(200);
        $response->seeJson($client0->toArray());
        $response->dontSeeJson(['name' => $client1->name]);
    }


    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = Client::factory()->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/client', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testRead()
    {
        $item = Client::factory()->create();
        $client = Client::first();
        $response = $this->actingAs($this->getAdminUser())->get('/client/' . $client->id);
        $response->seeStatusCode(200);
        $response->seeJson($client->toArray());
    }

    public function testUpdate()
    {
        $item = Client::factory()->create();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/client/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }

    public function testDelete()
    {
        $client = Client::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/client/' . $client->id);
        $response->seeStatusCode(204);
    }

    public function testAuth()
    {
        $response = $this->get('/clients');
        $response->seeStatusCode(401);
    }
}
