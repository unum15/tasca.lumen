<?php

use App\AccountsTable;
use Laravel\Lumen\Testing\WithoutMiddleware;

class AccountsTableControllerTest extends TestCase
{

    use WithoutMiddleware;
   
    public function testIndex()
    {
        $items = factory('App\AccountsTable', 2)->create();
        $response = $this->get('/accounts_table');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }    
    
    public function testCreate()
    {
        $item = factory('App\AccountsTable')->make();
        $response = $this->post('/accounts_table', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('accounts_table', $item->toArray());
    }
    
    public function testRead()
    {
        $item = factory('App\AccountsTable')->create();
        $response = $this->get('/accounts_table/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('accounts_table', $item->toArray());
    }
    
    public function testUpdate()
    {
        $item = factory('App\AccountsTable')->create();
        $update = ['name' => 'test'];
        $response = $this->patch('/accounts_table/' . $item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('accounts_table', $updated_array);
    }
    
    public function testDelete()
    {
        $item = factory('App\AccountsTable')->create();
        $response = $this->delete('/accounts_table/' . $item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('accounts_table', $item->toArray());
    }
}

