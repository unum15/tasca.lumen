<?php

use App\Appointment;

class AppointmentControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = Appointment::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/appointments');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = Appointment::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($user)->post('/appointment', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('appointments', $item->toArray());
    }
    
    public function testRead()
    {
        $item = Appointment::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/appointment/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('appointments', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = Appointment::factory()->create();
        $update = ['sort_order' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/appointment/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJson($updated_array);
        $this->seeInDatabase('appointments', $updated_array);
    }
    
    public function testDelete()
    {
        $item = Appointment::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/appointment/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('appointments', $item->toArray());
    }
}

