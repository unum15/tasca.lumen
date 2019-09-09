<?php

use App\TaskDate;

class TaskDateControllerTest extends TestCase
{    
    public function testIndex()
    {
        $item = factory('App\TaskDate')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/task_dates');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }
    
    public function testCreate()
    {
        $task = factory(App\Task::class)->create();
        $item = [
            'task_id' => $task->id,
            'date' => date('Y-m-d'),
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task_date', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = TaskDate::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateFull()
    {
        $task = factory(App\Task::class)->create();
        $item = [
            'task_id' => $task->id,
            'date' => date('Y-m-d'),
            'time' => '07:00:00',
            'day' => 'Mon',
            'notes' => 'Test data notes.',
            'sort_order' => 'first'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task_date', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = TaskDate::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }    
    
    public function testCreateBad()
    {
        $task = factory(App\Task::class)->create();
        $item = [
            'task_id' => null
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task_date', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["task_id" => ["The task id must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $task = factory(App\Task::class)->create();
        $item = [
            'task_id' => $task->id,
            'notes' => "a'; DROP TABLE tasks CASCADE; --"
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task_date', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = TaskDate::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/task_date', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['notes' => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = factory('App\TaskDate')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/task_date/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
        $dbitem = TaskDate::find($item->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/task_date/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $data = [
            'date' => date('Y-m-d'),
            'time' => '07:00:00',
            'day' => 'Mon',
            'notes' => 'Test Data',
            'sort_order' => 'first'
        ];
        $item = factory('App\TaskDate')->create();
        $patch = [
            'date' => '',
            'time' => '',
            'day' => '',
            'notes' => '',
            'sort_order' => ''
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/task_date/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $expected = [
            'date' => null,
            'time' => null,
            'day' => '',
            'notes' => '',
            'sort_order' => ''
        ];
        $response->seeJson($expected);
        $dbitem = TaskDate::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\TaskDate')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/task_date/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/task_dates');
        $response->seeStatusCode(401);
    }
}
