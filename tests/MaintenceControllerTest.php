<?php

use App\Maintence;
use Laravel\Lumen\Testing\WithoutMiddleware;

class MaintenceControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\Maintence', 2)->create();
        $response = $this->get('/maintence');
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $items->toArray()]);
        $this->seeInDatabase('maintence', $items[0]->toArray());
        $this->seeInDatabase('maintence', $items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\Maintence')->make();
        $response = $this->post('/maintence', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('maintence', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\Maintence')->create();
        $response = $this->get('/maintence/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('maintence', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\Maintence')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/maintence/' . $item->id, $update);
        $response->seeStatusCode(200);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('maintence', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\Maintence')->create();
        $response = $this->delete('/maintence/' . $item->id);
        $response->seeStatusCode(401);
        $response->seeJsonEquals([]);
        $this->notSeeInDatabase('maintence', $item->toArray());
    }
}

