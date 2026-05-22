<?php

use App\BackflowCleaning;

class BackflowCleaningControllerTest extends TestCase
{

    public function testIndex()
    {
        $items = BackflowCleaning::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_cleanings');
        $response->seeStatusCode(200);
        $this->seeJson($items[0]->toArray());
        $this->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $item = BackflowCleaning::factory()->make();
        $response = $this->actingAs($this->getAdminUser())->post('/backflow_cleaning', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_cleanings', $item->toArray());
    }

    public function testRead()
    {
        $item = BackflowCleaning::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/backflow_cleaning/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_cleanings', $item->toArray());
    }

    public function testUpdate()
    {
        $item = BackflowCleaning::factory()->create();
        $update = ['cleaned_on' => date('Y-m-d', strtotime('yesterday'))];
        $response = $this->actingAs($this->getAdminUser())->patch('/backflow_cleaning/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_cleanings', $updated_array);
    }

    public function testDelete()
    {
        $item = BackflowCleaning::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/backflow_cleaning/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_cleanings', $item->toArray());
    }

    public function testAuth()
    {
        $response = $this->get('/backflow_cleanings');
        $response->seeStatusCode(401);
    }
}
