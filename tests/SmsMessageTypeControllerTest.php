<?php

use App\SmsMessageType;

class SmsMessageTypeControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = SmsMessageType::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/sms_message_types');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = SmsMessageType::factory(['creator_id' => $user->id, 'updater_id' => $user->id])->make();
        $response = $this->actingAs($user)->post('/sms_message_type', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('sms_message_types', $item->toArray());
    }

    public function testRead()
    {
        $item = SmsMessageType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/sms_message_type/'.$item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('sms_message_types', $item->toArray());
    }

    public function testUpdate()
    {
        $item = SmsMessageType::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/sms_message_type/'.$item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('sms_message_types', $updated_array);
    }

    public function testDelete()
    {
        $item = SmsMessageType::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/sms_message_type/'.$item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('sms_message_types', $item->toArray());
    }
}
