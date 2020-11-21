<?php

use App\PropertyAccount;
use Laravel\Lumen\Testing\WithoutMiddleware;

class PropertyAccountControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\PropertyAccount', 2)->create();
        $response = $this->get('/property_accounts');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\PropertyAccount')->make();
        $response = $this->post('/property_account', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('property_accounts', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\PropertyAccount')->create();
        $response = $this->get('/property_account/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('property_accounts', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\PropertyAccount')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/property_account/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('property_accounts', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\PropertyAccount')->create();
        $response = $this->delete('/property_account/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('property_accounts', $item->toArray());
    }
}

