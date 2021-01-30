<?php

use App\ClockIn;
use App\Contact;
use App\LaborActivity;
use App\LaborAssignment;


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
    
    public function testCreateAssignedNoActivity()
    {
        $contact = Contact::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_assignment_id' => $labor_assignment->id
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(422);
    }
    
    public function testCreateAssignedNoAssignment()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_activity_id' => $labor_activity->id,
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(422);
    }
    
    public function testCreateAssignedNoClockIn()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'labor_assignment_id' => $labor_assignment->id,
          'labor_activity_id' => $labor_activity->id,
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(422);
    }
    
    public function testCreateAssignedNoOrderId()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create(['order_id' => null]);
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_activity_id' => $labor_activity->id,
          'labor_assignment_id' => $labor_assignment->id
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(422);
    }

    public function testCreateAssigned()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_activity_id' => $labor_activity->id,
          'labor_assignment_id' => $labor_assignment->id
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(201);
        unset($item['labor_assignment_id']);
        $response->seeJson($item);
        $this->seeInDatabase('clock_ins', $item);
    }
    
    public function testUpdateAssigned()
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
}

