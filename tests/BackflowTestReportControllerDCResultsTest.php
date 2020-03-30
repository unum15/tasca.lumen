<?php

use App\BackflowTestReport;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Http\Controllers\BackflowTestReportController;

class BackflowTestReportControllerDCResultsTest extends TestCase
{

    use WithoutMiddleware;


    public function testDCTestResultsBarely()
    {
        $test = ['reading_1' => 1, 'reading_2' => 1];
        $expected_results = [
            'check_1' => [
                'PSI' => $test['reading_1'],
                'closed_tight' => true,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => true,
                'leaked' => false
            ]
        ];
        $results = BackflowTestReportController::DCTestResults($test);
        $this->assertEquals($expected_results, $results);
    }


    public function testDCTestResultsExtra()
    {
        $test = ['reading_1' => 3, 'reading_2' => 10];
        $expected_results = [
            'check_1' => [
                'PSI' => $test['reading_1'],
                'closed_tight' => true,
                'leaked' => false
            ],
            'check_2' => [
                'PSI' => $test['reading_2'],
                'closed_tight' => true,
                'leaked' => false
            ]
        ];
        $results = BackflowTestReportController::DCTestResults($test);
        $this->assertEquals($expected_results, $results);
    }

    public function testDCReading1ResultGreaterThanOne()
    {
        $test = ['reading_1' => 1.9999, 'reading_2' => 10];
        $expected_results = [
            'PSI' => $test['reading_1'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::DCTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading1ResultEqualOne()
    {
        $test = ['reading_1' => 1, 'reading_2' => 10];
        $expected_results = [
            'PSI' => $test['reading_1'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::DCTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading1ResultLessThanOne()
    {
        $test = ['reading_1' => .9, 'reading_2' => 10];
        $expected_results = [
            'PSI' => $test['reading_1'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::DCTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading1ResultZero()
    {
        $test = ['reading_1' => 0, 'reading_2' => 10];
        $expected_results = [
            'PSI' => $test['reading_1'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::DCTestCheck1Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading2ResultGreaterThanOne()
    {
        $test = ['reading_1' => 10, 'reading_2' => 2];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::DCTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading2ResultEqualOne()
    {
        $test = ['reading_1' => 10, 'reading_2' => 1];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => true,
            'leaked' => false
        ];
        $results = BackflowTestReportController::DCTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading2ResultLessThanOne()
    {
        $test = ['reading_1' => 10, 'reading_2' => .9];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::DCTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
    public function testDCReading2ResultZero()
    {
        $test = ['reading_1' => 10, 'reading_2' => 0];
        $expected_results = [
            'PSI' => $test['reading_2'],
            'closed_tight' => false,
            'leaked' => true
        ];
        $results = BackflowTestReportController::DCTestCheck2Results($test);
        $this->assertEquals($expected_results, $results);
    }
    
}

