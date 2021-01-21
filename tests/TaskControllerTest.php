<?php

use App\Task;

class TaskControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = Task::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/tasks');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = Task::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/task', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('tasks', $item->toArray());
    }
    
    public function testRead()
    {
        $item = Task::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/task/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('tasks', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = Task::factory()->create();
        $update = ['group' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/task/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJson($updated_array);
        $this->seeInDatabase('tasks', $updated_array);
    }
    
    public function testDelete()
    {
        $item = Task::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/task/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('tasks', $item->toArray());
    }
}

