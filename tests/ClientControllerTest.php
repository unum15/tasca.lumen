<?php

use App\Client;

class ClientControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/clients');
        $response->seeStatusCode(200);
        $client = Client::first();
        $response->seeJson($client->toArray());
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
        $item = ['name' => 'Test 1'];
        $response = $this->actingAs($this->getAdminUser())->post('/client', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Client::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => ''];
        $response = $this->actingAs($this->getAdminUser())->post('/client', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE clients CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/client', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Client::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/client', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $client = Client::first();
        $response = $this->actingAs($this->getAdminUser())->get('/client/' . $client->id);
        $response->seeStatusCode(200);
        $response->seeJson($client->toArray());
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/client/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $client = Client::first();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/client/' . $client->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $client = Client::find($client->id);
        $response->seeJsonEquals($client->toArray());
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
