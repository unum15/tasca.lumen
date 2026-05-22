<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\StockTextMessage;
use App\SmsMessageType;

class StockTextMessageFactory extends Factory
{
    protected $model = StockTextMessage::class;

    
      public function definition()
    {
        $sms_message_type = SmsMessageType::factory()->create();

        return [
            'message' => $this->faker->text,
            'message_type_id' => $sms_message_type->id,
            'name' => null,
            'sort_order' => null,
            'creator_id' => null,
            'updater_id' => null,
        ];
    }
}
