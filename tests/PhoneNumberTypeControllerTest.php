<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\PhoneNumberType;

class PhoneNumberTypeControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number_types');
        $response->seeStatusCode(200);
        $dbitems = PhoneNumberType::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => false];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a'];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE phone_number_types CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/phone_number_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = PhoneNumberType::first();
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number_type/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
    }
    
    
    public function testReadBad()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/phone_number_type/a');
        $response->seeStatusCode(404);        
    }
    
    public function testUpdate()
    {
        $item = PhoneNumberType::first();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/phone_number_type/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = PhoneNumberType::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\PhoneNumberType')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/phone_number_type/' . $item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    public function testAuth()
    {
        $response = $this->get('/phone_number_types');
        $response->seeStatusCode(401);
    }
}
