<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\PhoneNumberType;

class PhoneNumberTypeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $items = [
                  ['name' => 'Test 1'],
                  ['name' => 'Test 2']
                ];
        $response0 = $this->post('/phone_number_type',$items[0]);
        $response0->seeStatusCode(200);                
        $response1 = $this->post('/phone_number_type',$items[1]);
        $response1->seeStatusCode(200);                
        $response = $this->get('/phone_number_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]);
        $response->seeJson($items[1]);
        $dbitems = PhoneNumberType::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a'];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["default" => ["The default field must be true or false."],"name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE phone_number_types CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());
        $response = $this->get('/phone_number_type/' . $response_array->id);
        $response->seeStatusCode(200);
        $response->seeJson($item);        
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testReadBad()
    {        
        $response = $this->get('/phone_number_type/a');
        $response->seeStatusCode(404);        
    }
    
    public function testCreateDoubleDefault()
    {
        $items = [
                  ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true],
                  ['name' => 'Test 2', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true]
                ];
        $response = $this->post('/phone_number_type',$items[0]);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());        
        $response = $this->post('/phone_number_type',$items[1]);
        $response->seeStatusCode(200);                
        $dbitem = PhoneNumberType::find($response_array->id);
        $this->assertEquals(false, $dbitem->default);
        $this->assertEquals(null, $dbitem->sort_order);
    }
    
    public function testUpdate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());
        $patch = ['name' => 'Test 2'];
        $response = $this->patch('/phone_number_type/' . $response_array->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = PhoneNumberType::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->post('/phone_number_type',$item);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());
        $response = $this->delete('/phone_number_type/' . $response_array->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    
}
