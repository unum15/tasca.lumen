<?php

use App\Property;

class PropertyControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = factory('App\Property', 2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/properties');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testIndexWithActivityLevel()
    {
        $activity_levels = factory('App\ActivityLevel', 5)->create();
        $property0 = factory('App\Property')->create(['activity_level_id' => $activity_levels[0]->id]);
        $property1 = factory('App\Property')->create(['activity_level_id' => $activity_levels[4]->id]);
        $response = $this->actingAs($this->getAdminUser())->get('/properties?maximium_activity_level_id=' . $activity_levels[0]->id);
        $response->seeStatusCode(200);
        $response->seeJson($property0->toArray());
        $response->dontSeeJson(['name' => $property1->name]);
    }

    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = factory('App\Property')->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/property', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $response->seeInDatabase('properties', $item->toArray());
    }

    public function testRead()
    {
        $item = factory('App\Property')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/property/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testUpdate()
    {
        $item = factory('App\Property')->create();
        $patch = ['name' => 'Test Property 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/property/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }
    
    public function testDelete()
    {
        $item = factory('App\Property')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/property/' . $item->id);
        $response->seeStatusCode(204);
    }

    public function testAuth()
    {
        $response = $this->get('/properties');
        $response->seeStatusCode(401);
    }
}
