<?php

use App\BackflowTest;

class BackflowTestControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowTest::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_tests');
        $response->seeStatusCode(200);
        $this->seeInDatabase('backflow_tests', $items[0]->toArray());
        $this->seeInDatabase('backflow_tests', $items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowTest::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_test', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_tests', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowTest::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_test/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_tests', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowTest::factory()->create();
        $update = ['notes' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_test/' . $item->id, $update);
        $response->seeStatusCode(200);
        $update['updated_at'] = date('Y-m-d H:i:s',strtotime(BackflowTest::find($item->id)['updated_at']));
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_tests', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowTest::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_test/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('backflow_tests', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_tests');
        $response->seeStatusCode(401);
    }
}
