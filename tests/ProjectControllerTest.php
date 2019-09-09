<?php

use App\Project;

class ProjectControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = factory('App\Project', 2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/projects');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }
    
    public function testCreate()
    {
        $admin = $this->getAdminUser();
        $item = factory('App\Project')->make(['creator_id' => $admin->id, 'updater_id' => $admin->id]);
        $response = $this->actingAs($admin)->post('/project', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testRead()
    {
        $item = factory('App\Project')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/project/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
    }    

    public function testUpdate()
    {
        $item = factory('App\Project')->create();
        $patch = ['name' => 'Test Project 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/project/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
    }
    
    public function testDelete()
    {
        $item = factory('App\Project')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/project/' . $item->id);
        $response->seeStatusCode(204);
    }

    public function testAuth()
    {
        $response = $this->get('/phone_numbers');
        $response->seeStatusCode(401);
    }
}
