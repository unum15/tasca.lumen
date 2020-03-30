<?php

use App\BackflowTestReport;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowTestReport', 2)->create();
        $response = $this->get('/backflow_test_reports');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_test_reports', $items[0]->toArray());
        $this->seeInDatabase('backflow_test_reports', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowTestReport')->make();
        $response = $this->post('/backflow_test_report', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_test_reports', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowTestReport')->create();
        $response = $this->get('/backflow_test_report/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_test_reports', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowTestReport')->create();
        $update = ['notes' => 'test'];
        $response = $this->patch('/backflow_test_report/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_test_reports', $updated_array);
    }
    /*
    public function testNullDate()
    {
        $item = factory('App\BackflowTestReport')->create();
        $update = ['submitted_date' => ''];
        $response = $this->patch('/backflow_test_report/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_test_reports', $updated_array);
    }
    */
    public function testDelete()
    {
        $item = factory('App\BackflowTestReport')->create();
        $response = $this->delete('/backflow_test_report/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_test_reports', $item->toArray());
    }
}

