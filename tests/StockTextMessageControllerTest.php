<?php

use App\StockTextMessage;

class StockTextMessageControllerTest extends TestCase
{
    public function testIndex()
    {
        $items = StockTextMessage::factory(2)->create();
        $response = $this->actingAs($this->getAdminUser())->get('/stock_text_messages');
        $response->seeStatusCode(200);
        $response->seeJson($items[0]->toArray());
        $response->seeJson($items[1]->toArray());
    }

    public function testCreate()
    {
        $user = $this->getAdminUser();
        $item = StockTextMessage::factory(['creator_id' => $user->id, 'updater_id' => $user->id])->make();
        $response = $this->actingAs($user)->post('/stock_text_message', $item->toArray());
        $response->seeStatusCode(201);
        $response->seeJson($item->toArray());
        $this->seeInDatabase('stock_text_messages', $item->toArray());
    }

    public function testRead()
    {
        $item = StockTextMessage::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->get('/stock_text_message/'.$item->id);
        $response->seeStatusCode(200);
        $response->seeJsonEquals(['data' => $item->toArray()]);
        $this->seeInDatabase('stock_text_messages', $item->toArray());
    }

    public function testUpdate()
    {
        $item = StockTextMessage::factory()->create();
        $update = ['name' => 'test'];
        $response = $this->actingAs($this->getAdminUser())->patch('/stock_text_message/'.$item->id, $update);
        $response->seeStatusCode(200);
        $item = $item->find($item->id);
        $updated_array = array_merge($item->toArray(), $update);
        $response->seeJsonEquals(['data' => $updated_array]);
        $this->seeInDatabase('stock_text_messages', $updated_array);
    }

    public function testDelete()
    {
        $item = StockTextMessage::factory()->create();
        $response = $this->actingAs($this->getAdminUser())->delete('/stock_text_message/'.$item->id);
        $response->seeStatusCode(204);
        $this->notSeeInDatabase('stock_text_messages', $item->toArray());
    }
}
