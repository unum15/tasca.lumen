<?php

use App\BackflowTestReport;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowTestReport::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_test_reports');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_test_reports', $items[0]->toArray());
        $this->seeInDatabase('backflow_test_reports', $items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowTestReport::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_test_report', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_test_reports', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowTestReport::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_test_report/' . $item->id);
        $response->seeStatusCode(200);
        $data = $item->toArray();
        $data['backflow_tests'] = [];
        $response->seeJsonEquals(['data' => $data]);
        $this->seeInDatabase('backflow_test_reports', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowTestReport::factory()->create();
        $update = ['notes' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_test_report/' . $item->id, $update);
        $response->seeStatusCode(200);
        $update['updated_at'] = date('Y-m-d H:i:s',strtotime(BackflowTestReport::find($item->id)['updated_at']));
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_test_reports', $updated_array);
    }
    /*
    public function testNullDate()
    {
        $item = BackflowTestReport::factory()->create();
        $update = ['submitted_date' => ''];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_test_report/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_test_reports', $updated_array);
    }
    */
    public function testDelete()
    {
        $item = BackflowTestReport::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_test_report/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('backflow_test_reports', $item->toArray());
    }

    // public function testAuth()
    // {
    //     $response = $this->get('/backflow_test_reports');
    //     $response->seeStatusCode(401);
    // }
}
