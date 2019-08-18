<?php

use App\TaskAction;

class TaskActionControllerTest extends TestCase
{
  
   public function testIndex()
   {
      $item = factory('App\TaskAction')->create();
      $response = $this->actingAs($this->getAdminUser())->get('/task_actions');
      $response->seeStatusCode(200);
      $response->seeJson($item->toArray());
    }    
    
   public function testCreate()
   {
      $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1];
      $response = $this->actingAs($this->getAdminUser())->post('/task_action',$item);
      $response->seeStatusCode(200);                
      $response->seeJson($item);
      $response_array = json_decode($response->response->getContent());
      $dbitem = TaskAction::find($response_array->id);
      $response->seeJsonEquals($dbitem->toArray());
   }
    
    
   public function testCreateBad()
   {
      $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a'];
      $response = $this->actingAs($this->getAdminUser())->post('/task_action',$item);
      $response->seeStatusCode(422);                
      $response->seeJson(["name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
   }
    
   public function testCreateInjection()
   {
      $item = ['name' => "a'; DROP TABLE task_actions CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --"];
      $response = $this->actingAs($this->getAdminUser())->post('/task_action',$item);
      $response->seeStatusCode(200);                
      $response->seeJson($item);
      $response_array = json_decode($response->response->getContent());        
      $dbitem = TaskAction::find($response_array->id);
      $response->assertNotNull($dbitem);
   }
    
   public function testCreateLong()
   {
      $item = [
         'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
         'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
      ];
      $response = $this->actingAs($this->getAdminUser())->post('/task_action',$item);
      $response->seeStatusCode(422);                
      $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
   }
    
   public function testRead()
   {
      $item = factory('App\TaskAction')->create();
      $response = $this->actingAs($this->getAdminUser())->get('/task_action/' . $item->id);
      $response->seeStatusCode(200);
      $response->seeJson($item->toArray());
   }

   public function testReadBad()
   {        
      $response = $this->actingAs($this->getAdminUser())->get('/task_action/a');
      $response->seeStatusCode(404);        
   }

   public function testUpdate()
   {
      $item = factory('App\TaskAction')->create();
      $patch = ['name' => 'Test 2'];
      $response = $this->actingAs($this->getAdminUser())->patch('/task_action/' . $item->id, $patch);
      $response->seeStatusCode(200);
      $response->seeJson($patch);
      $dbitem = TaskAction::find($item->id);
      $response->seeJsonEquals($dbitem->toArray());
   }
   
   public function testDelete()
   {
      $item = factory('App\TaskAction')->create();
      $response = $this->actingAs($this->getAdminUser())->delete('/task_action/' . $item->id);
      $response->seeStatusCode(204);
   }

   public function testAuth()
    {
        $response = $this->get('/task_actions');
        $response->seeStatusCode(401);
    }

}
