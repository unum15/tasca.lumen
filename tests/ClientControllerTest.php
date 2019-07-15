<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Client;
use App\Contact;

class ClientControllerTest extends TestCase
{
    
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/clients');
        $response->seeStatusCode(200);
        $client = Client::first();
        $response->seeJson($client->toArray());
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
        $response->seeJsonEquals([]);
    }
    
    public function testAuth()
    {
        $response = $this->get('/clients');
        $response->seeStatusCode(401);
    }
}
