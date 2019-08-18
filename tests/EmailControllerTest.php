<?php

use App\Contact;
use App\Email;
use App\EmailType;

class EmailControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->actingAs($this->getAdminUser())->get('/emails');
        $response->seeStatusCode(200);
        $dbitems = Email::all();
        $response->seeJsonEquals($dbitems->toArray());        
    }
    
    public function testCreate()
    {
        $user = $this->getAdminUser();
        $type = EmailType::first();
        $item = ['email' => 'Tester@test.com', 'contact_id' => $user->id, 'email_type_id' => $type->id];
        $response = $this->actingAs($this->getAdminUser())->post('/email', $item);
        $response->seeStatusCode(200);
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());
        $dbitem = Email::find($response_array->id);
        $response->seeJson($dbitem->toArray());
    }
    
    
    public function testCreateBad()
    {
        $item = ['email' => ''];
        $response = $this->actingAs($this->getAdminUser())->post('/email', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["email" => ["The email field is required."]]);
    }
    
    public function testCreateInjection()
    {
        $user = $this->getAdminUser();
        $type = EmailType::first();
        $item = ['email' => "a'; DROP TABLE emails CASCADE; --", 'contact_id' => $user->id, 'email_type_id' => $type->id];
        $response = $this->actingAs($this->getAdminUser())->post('/email', $item);
        $response->seeStatusCode(200);                
        $response->seeJson($item);
        $response_array = json_decode($response->response->getContent());        
        $dbitem = Email::find($response_array->id);
        $response->assertNotNull($dbitem);
    }
    
    public function testCreateLong()
    {
        $item = [
            'email' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'        
        ];
        $response = $this->actingAs($this->getAdminUser())->post('/email', $item);
        $response->seeStatusCode(422);                
        $response->seeJson(["email" => ["The email may not be greater than 255 characters."]]);
    }
    
    public function testRead()
    {
        $item = Email::first();
        $response = $this->actingAs($this->getAdminUser())->get('/email/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }
    
    
    public function testReadBad()
    {        
        $response = $this->actingAs($this->getAdminUser())->get('/email/a');
        $response->seeStatusCode(404);        
    }    
    
    public function testUpdate()
    {
        $item = Email::first();
        $patch = ['email' => 'Test2@test.com'];
        $response = $this->actingAs($this->getAdminUser())->patch('/email/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Email::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testDelete()
    {
        $item = factory('App\Email')->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/email/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/emails');
        $response->seeStatusCode(401);
    }
}
