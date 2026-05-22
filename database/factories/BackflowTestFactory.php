<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowTest;
use App\BackflowTestReport;

class BackflowTestFactory extends Factory
{
    protected $model = BackflowTest::class;

    public function definition()
    {
        $report = BackflowTestReport::factory()->create();

        return [
            'backflow_test_report_id' => $report->id,
            'contact_id' => null,
            'reading_1' => $this->faker->randomFloat(2, 0, 100),
            'reading_2' => $this->faker->randomFloat(2, 0, 100),
            'passed' => $this->faker->boolean,
            'tested_on' => $this->faker->date,
            'notes' => $this->faker->text,
        ];
    }
}
