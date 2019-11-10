<?php

use App\BackflowCertification;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowCertificationControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowCertification', 2)->create();
        $response = $this->get('/backflow_certifications');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('backflow_certifications', $items[0]->toArray());
        $this->seeInDatabase('backflow_certifications', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowCertification')->make();
        $response = $this->post('/backflow_certification', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_certifications', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowCertification')->create();
        $response = $this->get('/backflow_certification/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_certifications', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowCertification')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_certification/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_certifications', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowCertification')->create();
        $response = $this->delete('/backflow_certification/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('backflow_certifications', $item->toArray());
    }
}

