<?php

use App\Task;

class TaskControllerTest extends TestCase
{    
    public function testIndex()
    {
        $item = factory('App\Task')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/tasks');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }
    
    public function testCreate()
    {
        $item = [
            'name' => 'Test Task'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Task::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateFull()
    {
        $item = [
            'name' => 'Test Task',
            'notes' => 'foo'        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Task::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }    
    
    public function testCreateBad()
    {
        $item = [
            'name' => null,
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $item = [
            'name' => "a'; DROP TABLE tasks CASCADE; --"
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Task::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['name' => ["The name may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = factory('App\Task')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/task/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
        $dbitem = Task::find($item->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/task/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = factory('App\Task')->create();
        $patch = ['name' => 'Test Task 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/task/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Task::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\Task')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/task/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/tasks');
        $response->seeStatusCode(401);
    }
}
