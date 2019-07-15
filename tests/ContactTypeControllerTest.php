<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\ContactType;

class ContactTypeControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/contact_types');
        $response->seeStatusCode(200);
        $dbitems = ContactType::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->actingAs($this->getAdminUser())->post('/contact_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = ContactType::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a'];
        $response = $this->actingAs($this->getAdminUser())->post('/contact_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE contact_types CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/contact_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = ContactType::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/contact_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $contact_type = ContactType::first();
        $response = $this->actingAs($this->getAdminUser())->get('/contact_type/' . $contact_type->id);
        $response->seeStatusCode(200);
        $response->seeJson($contact_type->toArray());
        $dbitem = ContactType::find($contact_type->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/contact_type/a');
        $response->seeStatusCode(404);        
    }
    
    public function testUpdate()
    {
        $contact_type = ContactType::first();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/contact_type/' . $contact_type->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = ContactType::find($contact_type->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $contact_type = factory('App\ContactType')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/contact_type/' . $contact_type->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    public function testAuth()
    {
        $response = $this->get('/contact_types');
        $response->seeStatusCode(401);
    }
}
