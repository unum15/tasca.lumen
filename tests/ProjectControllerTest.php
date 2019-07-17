<?php

use App\ActivityLevel;
use App\PropertyType;
use App\Client;
use App\Contact;
use App\Project;
use App\Property;

class ProjectControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/projects');
        $response->seeStatusCode(200);
        $dbitems = Project::first();
        $response->seeJson($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $contact = Contact::first();
        $client = Client::first();
        $item = [
            'name' => 'Test Project',
            'contact_id' => $contact->id,
            'client_id' => $client->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/project', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Project::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateFull()
    {
        $contact = Contact::first();
        $client = Client::first();
        $item = [
            'name' => 'Test Project',
            'contact_id' => $contact->id,
            'client_id' => $client->id,
            'open_date' => date('Y-m-d'),
            'close_date' => date('Y-m-d'),
            'notes' => 'foo',            
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/project', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Project::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }    
    
    public function testCreateBad()
    {
        $contact = Contact::first();
        $client = Client::first();
        $item = [
            'name' => '',
            'contact_id' => $contact->id,
            'client_id' => $client->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/project', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $contact = Contact::first();
        $client = Client::first();
        $item = [
            'name' => "a'; DROP TABLE projects CASCADE; --",
            'contact_id' => $contact->id,
            'client_id' => $client->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/project', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Project::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    public function testCreateLong()
    {
        $contact = Contact::first();
        $client = Client::first();
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'contact_id' => $contact->id,
            'client_id' => $client->id,
            'open_date' => date('Y-m-d'),
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/project', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = Project::first();
        $response = $this->actingAs($this->getAdminUser())->get('/project/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/project/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = Project::first();
        $patch = ['name' => 'Test Project 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/project/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Project::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\Project')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/project/' . $item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }

    public function testAuth()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(401);
    }
}
