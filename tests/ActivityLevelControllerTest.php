<?php

use App\ActivityLevel;

class ActivityLevelControllerTest extends TestCase
{
   
    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/activity_levels');
        $response->seeStatusCode(200);
        $dbitems = ActivityLevel::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true];
        $response = $this->actingAs($this->getAdminUser())->post('/activity_level',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = ActivityLevel::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a'];
        $response = $this->actingAs($this->getAdminUser())->post('/activity_level',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["default" => ["The default field must be true or false."],"name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE activity_levels CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
        $response = $this->actingAs($this->getAdminUser())->post('/activity_level',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = ActivityLevel::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/activity_level',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $level = ActivityLevel::first();
        $response = $this->actingAs($this->getAdminUser())->get('/activity_level/' . $level->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals($level->toArray());
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/activity_level/a');
        $response->seeStatusCode(404);        
    }
    
    public function testUpdate()
    {
        $level = ActivityLevel::first();
        $patch = ['name' => 'Test 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/activity_level/' . $level->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = ActivityLevel::find($level->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $level = factory('App\ActivityLevel')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/activity_level/' . $level->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    
    public function testAuth()
    {
        $response = $this->get('/activity_levels');
        $response->seeStatusCode(401);
    }
}
