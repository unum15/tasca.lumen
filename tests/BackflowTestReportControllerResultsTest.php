<?php

use App\BackflowTestReport;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerResultsTest extends TestCase
{

    use WithoutMiddleware;


    public function testRPTestResultsBarely()
    {
        $test = ['reading_1' => 2, 'reading_2' => 7];
        $expected_results = [
            'check_1' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => false,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => 'OK',
                'closed_tight' => false,
                'leaked' => false
            ],
            'differential' => [
                'opened_at' => $test['reading_1'],
                'opened_under' => false,
                'did_not_open' => false
            ]
        ];
        $results = BackflowTestReportController::RPTestResults($test);
        $this->assertEquals($expected_results, $results);
    }


    public function testRPTestResultsExtra()
    {
        $test = ['reading_1' => 3, 'reading_2' => 10];
        $expected_results = [
            'check_1' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => false,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => 'OK',
                'closed_tight' => false,
                'leaked' => false
            ],
            'differential' => [
                'opened_at' => $test['reading_1'],
                'opened_under' => false,
                'did_not_open' => false
            ]
        ];
        $results = BackflowTestReportController::RPTestResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestDifferentialResultsLessThanTwo()
    {
        $test = ['reading_1' => 1.9999, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => true,
            'did_not_open' => false
        ];
        $results = BackflowTestReportController::RPTestDifferentialResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestDifferentialResultsZero()
    {
        $test = ['reading_1' => 0, 'reading_2' => 10, 'passed' => false];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => false,
            'did_not_open' => true
        ];
        $results = BackflowTestReportController::RPTestDifferentialResults($test);
        $this->assertEquals($expected_results, $results);
    }
}

