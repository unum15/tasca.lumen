<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\TaskType;
class TaskTypeFactory extends Factory
{
    protected $model = TaskType::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
