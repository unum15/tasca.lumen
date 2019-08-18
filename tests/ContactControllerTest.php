<?php

use App\Contact;

class ContactControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/contacts');
        $response->seeStatusCode(200);
        $contact = Contact::first();
        $response->seeJson($contact->toArray());
    }
    
    public function testIndexWithActivityLevel()
    {
        $activity_levels = factory('App\ActivityLevel', 5)->create();
        $contact0 = factory('App\Contact')->create(['activity_level_id' => $activity_levels[0]->id]);
        $contact1 = factory('App\Contact')->create(['activity_level_id' => $activity_levels[4]->id]);
        $response = $this->actingAs($this->getAdminUser())->get('/contacts?maximium_activity_level_id=' . $activity_levels[0]->id);
        $response->seeStatusCode(200);
        $response->seeJson($contact0->toArray());
        $response->dontSeeJson(['name' => $contact1->name]);
    }

    public function testCreate()
    {
        $item = ['name' => 'Test 1'];
        $response = $this->actingAs($this->getAdminUser())->post('/contact', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Contact::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => ''];
        $response = $this->actingAs($this->getAdminUser())->post('/contact', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE contacts CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/contact', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Contact::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/contact', $item);
        $response->seeStatusCode(422);
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $contact = Contact::first();
        $response = $this->actingAs($this->getAdminUser())->get('/contact/' . $contact->id);
        $response->seeStatusCode(200);
        $response->seeJson($contact->toArray());
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/contact/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $contact = Contact::first();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/contact/' . $contact->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Contact::find($contact->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $contact = factory('App\Contact')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/contact/' . $contact->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/contacts');
        $response->seeStatusCode(401);
    }
}
