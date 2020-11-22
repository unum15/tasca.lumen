<?php

use App\OverheadCategory;
use Laravel\Lumen\Testing\WithoutMiddleware;

class OverheadCategoryControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\OverheadCategory', 2)->create();
        $response = $this->get('/overhead_categories');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\OverheadCategory')->make();
        $response = $this->post('/overhead_category', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('overhead_categories', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\OverheadCategory')->create();
        $response = $this->get('/overhead_category/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('overhead_categories', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\OverheadCategory')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/overhead_category/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('overhead_categories', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\OverheadCategory')->create();
        $response = $this->delete('/overhead_category/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('overhead_categories', $item->toArray());
    }
}

