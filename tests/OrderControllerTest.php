<?php

use App\Order;
use App\Property;

class OrderControllerTest extends TestCase
{

    public function testIndex()
    {
        $item = Order::factory()->create();
        $item = Order::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/orders');
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
    }

    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = Order::factory(['creator_id'=>$user->id,'updater_id'=>$user->id])->make();
        $response = $this->actingAs($this->getAdminUser())->post('/order', $item->toArray());
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $response_array = json_decode($response->response->getContent());
        $dbitem = Order::find($response_array->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }

    public function testRead()
    {
        $item = Order::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/order/' . $item->id);
        $response->seeStatusCode(200);
        $response->seeJson($item->toArray());
        $dbitem = Order::find($item->id);
        $response->seeJson($dbitem->toArray());
        $dbitem->delete();
    }    
       
    public function testUpdate()
    {
        $item = Order::factory()->create();
        $patch = ['name' => 'Test ServiceOrder 2'];
        $response = $this->actingAs($this->getAdminUser())->patch('/order/' . $item->id, $patch);
        $response->seeStatusCode(200);
        $response->seeJson($patch);
        $dbitem = Order::find($item->id);
        $response->seeJsonEquals($dbitem->toArray());
    }
    
    public function testConversion()
    {
        $item = Order::factory()->create(['recurring' => false, 'renewable'=> false, 'close_date' => null]);
        $item['close_date'] = date('Y-m-d');
        $response = $this->actingAs($this->getAdminUser())->post('/order/convert/' . $item->id);
        $response->seeStatusCode(200);
        $itemArray = $item->toArray();
        $response->seeJsonEquals([$itemArray]);
    }
    
    public function testRenewal()
    {
        $item = Order::factory('App\Order')->create(['recurring' => false, 'renewable'=> true, 'close_date' => null]);
        $prop1 = Property::factory()->create();
        $prop2 = Property::factory()->create();
        $item->properties()->sync([$prop1->id, $prop2->id]);
        $item['close_date'] = date('Y-m-d');
        $response = $this->actingAs($this->getAdminUser())->post('/order/convert/' . $item->id);
        $response->seeStatusCode(200);
        $itemArray = $item->toArray();
        $response->seeJsonEquals([$itemArray]);
    }
    
    public function testConversionRecurring()
    {
        $item = Order::factory('App\Order')->create(['recurring' => true, 'renewable'=> false]);
        $prop1 = Property::factory()->create();
        $prop2 = Property::factory()->create();
        $item->properties()->sync([$prop1->id, $prop2->id]);
        $item['close_date'] = date('Y-m-d');
        $response = $this->actingAs($this->getAdminUser())->post('/order/convert/' . $item->id);
        $response->seeStatusCode(200);
        $itemArray = $item->toArray();
        $response->seeJsonEquals([$itemArray]);
    }
    
    public function testConversionProperties()
    {
        $item = Order::factory('App\Order')->create(['recurring' => false, 'renewable'=> false]);
        $prop1 = Property::factory()->create();
        $prop2 = Property::factory()->create();
        $item->properties()->sync([$prop1->id, $prop2->id]);
        $item->save();
        $dbitem = Order::with('properties')->find($item->id);
        $item['close_date'] = date('Y-m-d');
        $response = $this->actingAs($this->getAdminUser())->post('/order/convert/' . $item->id, $dbitem->toArray());
        $response->seeStatusCode(200);
        $itemArray = $item->toArray();
        $response->seeJson($itemArray);
    }
    
    public function testDelete()
    {
        $item = Order::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/order/' . $item->id);
        $response->seeStatusCode(204);
    }
    
    public function testAuth()
    {
        $response = $this->get('/orders');
        $response->seeStatusCode(401);
    }
}
