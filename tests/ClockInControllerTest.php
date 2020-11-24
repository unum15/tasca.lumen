<?php

use App\ClockIn;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ClockInControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\ClockIn', 2)->create();
        $response = $this->get('/clock_ins');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\ClockIn')->make();
        unset($item['creator_id']);
        unset($item['updater_id']);
        $response = $this->actingAs($this->getAdminUser())->post('/clock_in', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('clock_ins', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\ClockIn')->create();
        $response = $this->get('/clock_in/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('clock_ins', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\ClockIn')->create();
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
        $item = factory('App\ClockIn')->create();
        $response = $this->delete('/clock_in/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('clock_ins', $item->toArray());
    }
}

