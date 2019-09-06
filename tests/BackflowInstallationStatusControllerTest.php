<?php

use App\BackflowInstallationStatus;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowInstallationStatusControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowInstallationStatus', 2)->create();
        $response = $this->get('/backflow_installation_statuses');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_installation_statuses', $items[0]->toArray());
        $this->seeInDatabase('backflow_installation_statuses', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowInstallationStatus')->make();
        $response = $this->post('/backflow_installation_status', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_installation_statuses', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowInstallationStatus')->create();
        $response = $this->get('/backflow_installation_status/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_installation_statuses', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowInstallationStatus')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_installation_status/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_installation_statuses', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowInstallationStatus')->create();
        $response = $this->delete('/backflow_installation_status/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_installation_statuses', $item->toArray());
    }
}

