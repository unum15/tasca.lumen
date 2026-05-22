<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowRepair;
use App\BackflowTestReport;
use App\Contact;
use App\BackflowValve;
use App\BackflowValvePart;

class BackflowRepairFactory extends Factory
{
    protected $model = BackflowRepair::class;

    public function definition()
    {
        $report = BackflowTestReport::factory()->create();
        $contact = Contact::factory()->create();
        $valve = BackflowValve::factory()->create();
        $part = BackflowValvePart::factory()->create();

        return [
            'backflow_test_report_id' => $report->id,
            'contact_id' => $contact->id,
            'backflow_valve_id' => $valve->id,
            'backflow_valve_part_id' => $part->id,
            'repaired_on' => $this->faker->date,
        ];
    }
}
