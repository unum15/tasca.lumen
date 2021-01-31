<?php

use App\Appointment;
use App\ClockIn;
use App\Contact;
use App\LaborActivity;
use App\LaborAssignment;
use App\Task;


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
        $task = [
            'labor_assignment_id' => $item['labor_assignment_id'],
            'completion_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'closed_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'order_id' => $labor_assignment->order_id,
            'name' => $labor_assignment->name,
            'labor_type_id' => $labor_assignment->labor_type_id,
        ];
        $this->seeInDatabase('tasks', $task);
        $appointment = [
            'date' => date('Y-m-d',strtotime($item['clock_in'])),
            'time' => date('H:i:s',strtotime($item['clock_in'])),
        ];
        $this->seeInDatabase('appointments', $appointment);
        unset($item['labor_assignment_id']);
        $response->seeJson($item);
        $this->seeInDatabase('clock_ins', $item);
        
    }
    
    public function testCreateAssignedExistingTask()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $task = Task::factory()->create(['order_id' => $labor_assignment->order_id, 'labor_assignment_id' => $labor_assignment->id, 'labor_type_id' => $labor_assignment->labor_type_id,'name' => $labor_assignment->name ]);
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_activity_id' => $labor_activity->id,
          'labor_assignment_id' => $labor_assignment->id
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(201);
        $task_array = [
            'labor_assignment_id' => $task->labor_assignment_id,
            'completion_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'closed_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'order_id' => $task->order_id,
            'name' => $task->name,
            'labor_type_id' => $task->labor_type_id,
        ];
        $this->seeInDatabase('tasks', $task_array);
        $appointment = [
            'task_id' => $task->id,
            'date' => date('Y-m-d',strtotime($item['clock_in'])),
            'time' => date('H:i:s',strtotime($item['clock_in'])),
        ];
        $this->seeInDatabase('appointments', $appointment);
        unset($item['labor_assignment_id']);
        $response->seeJson($item);
        $this->seeInDatabase('clock_ins', $item);
        
    }
    
    public function testCreateAssignedExistingTaskExistingAppointment()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $task = Task::factory()->create(['order_id' => $labor_assignment->order_id, 'labor_assignment_id' => $labor_assignment->id, 'labor_type_id' => $labor_assignment->labor_type_id,'name' => $labor_assignment->name ]);
        $appointment = Appointment::factory()->create(['task_id' => $task->id, 'date' => date('Y-m-d')]);
        $user = $this->getAdminUser();
        $item = [
          'contact_id' => $contact->id,
          'clock_in' => date('Y-m-d H:i:s'),
          'labor_activity_id' => $labor_activity->id,
          'labor_assignment_id' => $labor_assignment->id
        ];
        $response = $this->actingAs($user)->post('/clock_in/assigned', $item);
        $response->seeStatusCode(201);
        $task_array = [
            'labor_assignment_id' => $task->labor_assignment_id,
            'completion_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'closed_date' => date('Y-m-d',strtotime($item['clock_in'])),
            'order_id' => $task->order_id,
            'name' => $task->name,
            'labor_type_id' => $task->labor_type_id,
        ];
        $this->seeInDatabase('tasks', $task_array);
        unset($item['labor_assignment_id']);
        $response->seeJson($item);
        $clock_in_array = [
            'appointment_id' => $appointment->id,
            'contact_id' => $contact->id,
            'clock_in' => $item['clock_in'],
            'labor_activity_id' => $labor_activity->id
        ];
        $this->seeInDatabase('clock_ins', $clock_in_array);
        
    }
    
    public function testClockOutAssignedNoActivity()
    {
        $user = $this->getAdminUser();
        $item = ClockIn::factory()->create();
        $clock_out = [
            'clock_out' => date('Y-m-d H:i:s'),
            'labor_assignment_id' => $item->appointment->task->labor_assignment_id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(422);
    }
    
    public function testClockOutAssignedNoAssignment()
    {
        $user = $this->getAdminUser();
        $item = ClockIn::factory()->create();
        $clock_out = [
            'clock_out' => date('Y-m-d H:i:s'),
            'labor_activity_id' => $item->labor_activity_id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(422);
    }
    
    public function testClockOutAssignedNoClockOut()
    {
        $user = $this->getAdminUser();
        $item = ClockIn::factory()->create();
        $clock_out = [
            'labor_activity_id' => $item->labor_activity_id,
            'labor_assignment_id' => $item->appointment->task->labor_assignment_id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(422);
    }
    
    public function testClockOutAssignedNoOrderId()
    {
        $labor_assignment = LaborAssignment::factory()->create(['order_id' => null]);
        $user = $this->getAdminUser();
        $item = ClockIn::factory()->create();
        $clock_out = [
            'clock_out' => date('Y-m-d H:i:s'),
            'labor_activity_id' => $item->labor_activity_id,
            'labor_assignment_id' => $labor_assignment->id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(422);
    }
    
    public function testClockoutAssigned()
    {
        $item = ClockIn::factory()->create();
        $clock_out = [
            'clock_out' => date('Y-m-d H:i:s'),
            'labor_activity_id' => $item->labor_activity_id,
            'labor_assignment_id' => $item->appointment->task->labor_assignment_id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(200);
        unset($clock_out['labor_assignment_id']);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $clock_out);
        $response->seeJson($updated_array);
        $this->seeInDatabase('clock_ins', $updated_array);
    }
    
    
    
    public function testClockOutAssignedNewActivityAndAssignment()
    {
        $contact = Contact::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $user = $this->getAdminUser();
        $item = ClockIn::factory()->create();
        $clock_out = [
            'clock_out' => date('Y-m-d H:i:s'),
            'labor_activity_id' => $labor_activity->id,
            'labor_assignment_id' => $labor_assignment->id,
            'notes' => 'test'
        ];
        $response = $this->actingAs($this->getAdminUser())->patch('/clock_out/assigned/' . $item->id, $clock_out);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        unset($clock_out['labor_assignment_id']);
        $updated_array = array_merge($item->toArray(), $clock_out);
        $response->seeJson($updated_array);
        $task = [
            'labor_assignment_id' => $labor_assignment->id,
            'completion_date' => date('Y-m-d',strtotime($clock_out['clock_out'])),
            'closed_date' => date('Y-m-d',strtotime($clock_out['clock_out'])),
            'order_id' => $labor_assignment->order_id,
            'name' => $labor_assignment->name,
            'labor_type_id' => $labor_assignment->labor_type_id,
        ];
        $this->seeInDatabase('tasks', $task);
        $this->seeInDatabase('clock_ins', $updated_array);
    }

}

