<?php

use App\Part;
use Laravel\Lumen\Testing\WithoutMiddleware;

class PartControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Part', 2)->create();
        $response = $this->get('/parts');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('parts', $items[0]->toArray());
        $this->seeInDatabase('parts', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Part')->make();
        $response = $this->post('/part', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('parts', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Part')->create();
        $response = $this->get('/part/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('parts', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Part')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/part/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('parts', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Part')->create();
        $response = $this->delete('/part/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('parts', $item->toArray());
    }
}

