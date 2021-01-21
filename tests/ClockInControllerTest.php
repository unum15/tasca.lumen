<?php

use App\ClockIn;

class ClockInControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = ClockIn::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/clock_ins');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = ClockIn::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/clock_in', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('clock_ins', $item->toArray());
    }
    
    public function testRead()
    {
        $item = ClockIn::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/clock_in/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('clock_ins', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = ClockIn::factory()->create();
        $update = ['notes' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_in/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJson($updated_array);
        $this->seeInDatabase('clock_ins', $updated_array);
    }
    
    public function testDelete()
    {
        $item = ClockIn::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/clock_in/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('clock_ins', $item->toArray());
    }
}

