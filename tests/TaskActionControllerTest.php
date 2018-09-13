<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\TaskStatus;
use App\TaskAction;

class TaskActionControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(){
      parent::setUp();
      $this->status = TaskStatus::create(['name' => 'Test Status']);
      $this->item = TaskAction::create(['name' => 'Test Action', 'task_status_id' => $this->status->id]);      
    }
    
    public function tearDown(){
      parent::tearDown();
      $this->status->delete();
      if(isset($this->item)){
        $this->item->delete();
      }      
    }
    
    public function testIndex()
    {
        $response = $this->get('/task_actions');
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());
        $dbitems = TaskAction::all();
        $response->seeJsonEquals($dbitems->toArray());
    }    
    
    public function testCreate()
    {
        $item = ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'task_status_id' => $this->status->id];
        $response = $this->post('/task_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = TaskAction::find($response_array->id);
        $response->seeJsonEquals($dbitem->toArray());
        $dbitem->delete();
    }
    
    
    public function testCreateBad()
    {
        $item = ['name' => '', 'sort_order' => 'a', 'default' => 'a',  'task_status_id' => 'a'];
        $response = $this->post('/task_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["default" => ["The default field must be true or false."],"name" => ["The name field is required."],"sort_order" => ["The sort order must be an integer."]]);
    }
    
    public function testCreateInjection()
    {
        $item = ['name' => "a'; DROP TABLE task_actions CASCADE; --", 'notes' => "a'; DROP TABLE activity_levels CASCADE; --",  'task_status_id' => $this->status->id];
        $response = $this->post('/task_action',$item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = TaskAction::find($response_array->id);
        $response->assertNotNull($dbitem);
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'task_status_id' => $this->status->id
        ];
        $response = $this->post('/task_action',$item);
        $response->seeStatusCode(422);                
        $response->seeJson(["name" => ["The name may not be greater than 255 characters."],"notes" => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {        
        $response = $this->get('/task_action/' . $this->item->id);
        $response->seeStatusCode(200);
        $response->seeJson($this->item->toArray());
    }
    
    
    public function testReadBad()
    {        
        $response = $this->get('/task_action/a');
        $response->seeStatusCode(404);        
    }
    
    public function testCreateDoubleDefault()
    {
        $items = [
                  ['name' => 'Test 1', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'task_status_id' => $this->status->id],
                  ['name' => 'Test 2', 'notes' => 'Test Notes', 'sort_order' => 1, 'default' => true, 'task_status_id' => $this->status->id]
                ];
        $response = $this->post('/task_action',$items[0]);
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());        
        $response = $this->post('/task_action',$items[1]);
        $response->seeStatusCode(200);                
        $dbitem = TaskAction::find($response_array->id);
        $this->assertEquals(false, $dbitem->default);
        $this->assertEquals(null, $dbitem->sort_order);
    }
    
    public function testUpdate()
    {
        $patch = ['name' => 'Test 2'];
        $response = $this->patch('/task_action/' . $this->item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = TaskAction::find($this->item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {    
        $response = $this->delete('/task_action/' . $this->item->id);
        $response->seeStatusCode(204);        
        $response->seeJsonEquals([]);
    }
    

}
