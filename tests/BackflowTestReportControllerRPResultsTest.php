<?php

use App\BackflowTestReport;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerRPResultsTest extends TestCase
{

    use WithoutMiddleware;


    public function testRPTestResultsBarely()
    {
        $test = ['reading_1' => 2, 'reading_2' => 7];
        $expected_results = [
            'check_1' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => true,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => true,
                'closed_tight' => true,
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
                'closed_tight' => true,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => true,
                'closed_tight' => true,
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
        $test = ['reading_1' => 0, 'reading_2' => 10];
        $expected_results = [
            'opened_at' => $test['reading_1'],
            'opened_under' => false,
            'did_not_open' => true
        ];
        $results = BackflowTestReportController::RPTestDifferentialResults($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve2ResultBlank()
    {
        $test = ['reading_1' => 2, 'reading_2' => null];
        $expected_results = [
            'PSI' => false,
            'closed_tight' => false,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve1ResultBlank()
    {
        $test = ['reading_1' => 2, 'reading_2' => null];
        $expected_results = [
            'PSI' => null,
            'closed_tight' => false,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve2ResultGreater()
    {
        $test = ['reading_1' => 2, 'reading_2' => 3];
        $expected_results = [
            'PSI' => true,
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve2ResultEqual()
    {
        $test = ['reading_1' => 2, 'reading_2' => 2];
        $expected_results = [
            'PSI' => true,
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve1ResultGreater()
    {
        $test = ['reading_1' => 2, 'reading_2' => 3];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve1ResultEqual()
    {
        $test = ['reading_1' => 2, 'reading_2' => 2];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::RPTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve2ResultLess()
    {
        $test = ['reading_1' => 2, 'reading_2' => 1];
        $expected_results = [
            'PSI' => false,
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::RPTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testRPTestCheckValve1ResultLess()
    {
        $test = ['reading_1' => 2, 'reading_2' => 1];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::RPTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
}

