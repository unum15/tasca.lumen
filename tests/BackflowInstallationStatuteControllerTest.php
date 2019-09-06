<?php

use App\BackflowInstallationStatute;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowInstallationStatuteControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowInstallationStatute', 2)->create();
        $response = $this->get('/backflow_installation_statutes');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_installation_statutes', $items[0]->toArray());
        $this->seeInDatabase('backflow_installation_statutes', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowInstallationStatute')->make();
        $response = $this->post('/backflow_installation_statute', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_installation_statutes', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowInstallationStatute')->create();
        $response = $this->get('/backflow_installation_statute/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_installation_statutes', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowInstallationStatute')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_installation_statute/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_installation_statutes', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowInstallationStatute')->create();
        $response = $this->delete('/backflow_installation_statute/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_installation_statutes', $item->toArray());
    }
}

