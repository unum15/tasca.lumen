<?php

use App\SignIn;

class SignInControllerTest extends TestCase
{    
    public function testIndex()
    {
        $item = factory('App\SignIn')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/sign_ins');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }
    
    public function testIndexWithDates()
    {
        $item0 = factory('App\SignIn')->create(['sign_in' => '2019-01-01 09:00:00', 'sign_out' => '2019-01-01 11:00:00']);
        $item1 = factory('App\SignIn')->create(['sign_in' => '2019-02-01 09:00:00', 'sign_out' => '2019-02-01 11:00:00']);
        $response = $this->actingAs($this->getAdminUser())->get('/sign_ins?start_date=2019-02-01&stop_date=2019-02-28');
        $response->seeStatusCode(200);
        $response->dontSeeJson(['sign_in' => '2019-01-01 09:00:00', 'sign_out' => '2019-01-01 11:00:00']);
        $response->seeJson($item1->toArray());
    }
    
    public function testCreate()
    {
        $response = $this->actingAs($this->getAdminUser())->post('/sign_in');
        $response->seeStatusCode(200);
        $response_array = json_decode($response->response->getContent());
        $dbitem = SignIn::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateFull()
    {
        $item = [
            'sign_in' => date('Y-m-d h:i:s'),
            'sign_out' => date('Y-m-d h:i:s'),
            'notes' => 'foo'        ];
        $response = $this->actingAs($this->getAdminUser())->post('/sign_in', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = SignIn::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }    
    
    public function testCreateBad()
    {
        $item = [
            'sign_in' => null,
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/sign_in', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["sign_in" => ["The sign in must be a string."]]);
    }
    
    public function testCreateInjection()
    {
        $item = [
            'notes' => "a'; DROP TABLE tasks CASCADE; --"
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/sign_in', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = SignIn::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }
    
    public function testCreateLong()
    {
        $item = [
            'notes' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/sign_in', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(['notes' => ["The notes may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = factory('App\SignIn')->create();
        $response = $this->actingAs($this->getAdminUser())->get('/sign_in/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());        
        $dbitem = SignIn::find($item->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
    
    public function testReadBad()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/sign_in/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = factory('App\SignIn')->create();
        $patch = ['sign_out' => date('Y-m-d h:i:s')];
        $response = $this->actingAs($this->getAdminUser())->patch('/sign_in/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = SignIn::find($item->id);
        $response->seeJson($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\SignIn')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/sign_in/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/sign_ins');
        $response->seeStatusCode(401);
    }
}
