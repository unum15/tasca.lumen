<?php

use App\BackflowPicture;
use Laravel\Lumen\Testing\WithoutMiddleware;

class BackflowPictureControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\BackflowPicture', 2)->create();
        $response = $this->get('/backflow_pictures');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\BackflowPicture')->make();
        $response = $this->post('/backflow_picture', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('backflow_pictures', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\BackflowPicture')->create();
        $response = $this->get('/backflow_picture/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('backflow_pictures', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\BackflowPicture')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/backflow_picture/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('backflow_pictures', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\BackflowPicture')->create();
        $response = $this->delete('/backflow_picture/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('backflow_pictures', $item->toArray());
    }
}

