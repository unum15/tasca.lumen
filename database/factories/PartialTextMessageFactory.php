<?php

namespace Database\Factories;

use App\PartialTextMessage;
use App\PartialTextMessageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartialTextMessageFactory extends Factory
{
    protected $model = PartialTextMessage::class;

    public function definition()
    {
        $partial_text_message_type = PartialTextMessageType::factory()->create();

        return [
            'message' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'partial_text_message_type_id' => $partial_text_message_type->id,
        ];
    }
}
