<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowTestReport;
use App\BackflowAssembly;

class BackflowTestReportFactory extends Factory
{
    protected $model = BackflowTestReport::class;

    public function definition()
    {
        $assembly = BackflowAssembly::factory()->create();

        return [
            'backflow_assembly_id' => $assembly->id,
            'report_date' => $this->faker->date,
            'notes' => $this->faker->text,
            'visual_inspection_notes' => null,
            'backflow_installed_to_code' => $this->faker->boolean,
            'submitted_date' => null,
            'tag_year' => null,
        ];
    }
}
