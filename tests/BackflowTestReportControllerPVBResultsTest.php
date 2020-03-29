<?php

use App\BackflowTestReport;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerPVBResultsTest extends TestCase
{

    use WithoutMiddleware;


    public function testPVBTestResultsBarely()
    {
        $test = ['reading_1' => 1, 'reading_2' => 1];
        $expected_results = [
            'check' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => true,
                'leaked' => false
            ],
            'air_inlet' => [
                'opened_at' => $test['reading_1'],
                'opened_under' => false,
                'did_not_open' => false
            ]
        ];
        $results = BackflowTestReportController::PVBTestResults($test);
        $this->assertEquals($expected_results, $results);
    }


    public function testPVBTestResultsExtra()
    {
        $test = ['reading_1' => 2, 'reading_2' => 2];
        $expected_results = [
            'check' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => true,
                'leaked' => false
            ],
            'air_inlet' => [
                'opened_at' => $test['reading_1'],
                'opened_under' => false,
                'did_not_open' => false
            ]
        ];
        $results = BackflowTestReportController::PVBTestResults($test);
        $this->assertEquals($expected_results, $results);
    }

    public function testPVBTestAirInletResultsGreaterThanOne()
    {
        $test = ['reading_1' => 1.9999, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => false,
            'did_not_open' => false
        ];
        $results = BackflowTestReportController::PVBTestAirInletResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testPVBTestAirInletResultsEqualsOne()
    {
        $test = ['reading_1' => 1, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => false,
            'did_not_open' => false
        ];
        $results = BackflowTestReportController::PVBTestAirInletResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testPVBTestAirInletResultsLessThanOne()
    {
        $test = ['reading_1' => .5, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => true,
            'did_not_open' => false
        ];
        $results = BackflowTestReportController::PVBTestAirInletResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testPVBTestAirInletResultsEqualsZero()
    {
        $test = ['reading_1' => 0, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => false,
            'did_not_open' => true
        ];
        $results = BackflowTestReportController::PVBTestAirInletResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    
    public function testPVBTestCheckValveResultGreaterThanOne()
    {
        $test = ['reading_1' => 2, 'reading_2' => 3];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::PVBTestCheckResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testPVBTestCheckValveResultEqualToOne()
    {
        $test = ['reading_1' => 2, 'reading_2' => 1];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::PVBTestCheckResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    
    public function testPVBTestCheckValveResultLessThanOne()
    {
        $test = ['reading_1' => 2, 'reading_2' => .5];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::PVBTestCheckResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
}

