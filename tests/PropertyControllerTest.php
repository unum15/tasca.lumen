<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\ActivityLevel;
use App\PropertyType;
use App\Client;
use App\Contact;
use App\Property;

class PropertyControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/properties');
        $response->seeStatusCode(200);
        $dbitems = Property::first();
        $response->seeJson($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $activity_level = ActivityLevel::first();
        $client = Client::first();
        $contact = Contact::first();
        $property_type = PropertyType::first();
        $item = [
            'name' => 'Test Property',
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateFull()
    {
        $activity_level = ActivityLevel::first();
        $client = Client::first();
        $contact = Contact::first();
        $property_type = PropertyType::first();
        $item = [
            'name' => 'Test Property',
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }    
    
    public function testCreateBad()
    {
        $activity_level = ActivityLevel::first();
        $client = Client::first();
        $contact = Contact::first();
        $property_type = PropertyType::first();
        $item = [
            'name' => '',
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/property', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $activity_level = ActivityLevel::first();
        $client = Client::first();
        $contact = Contact::first();
        $property_type = PropertyType::first();
        $item = [
            'name' => "a'; DROP TABLE propertys CASCADE; --",
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/property', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Property::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    public function testCreateLong()
    {
        $activity_level = ActivityLevel::first();
        $client = Client::first();
        $contact = Contact::first();
        $property_type = PropertyType::first();
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/property', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = Property::first();
        $response = $this->actingAs($this->getAdminUser())->get('/property/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $dbitem = Property::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/property/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = Property::first();
        $patch = ['name' => 'Test Property 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/property/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Property::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\Property')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/property/' . $item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }

    public function testAuth()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(401);
    }
}
