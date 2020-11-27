<?php

use PHPUnit\Framework\TestCase;

require_once '../services/OeeService.php';
/* require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/OeeService.php'; */

class OeeServiceTest extends TestCase
{

    protected $productionservice;
    protected $availability;
    protected $runtime;
    protected $performance;
    protected $quality;
    protected $oeeForBatch;
    protected $prodlistid;
    protected $timeDifference;
    protected $idealcycletimeOeeForBatch;
    protected $batchResultOeeForBatch;
    protected $idealcycletimeOeeOneDay;
    protected $batchResultOeeOneDay;
    protected $oeeservice;


    protected function setUp(): void
    {
        $this->oeeservice = new OeeService();
        $this->availability = 96.969696969697;
        $this->runtime = 260;
        $this->performance = 93.75;
        $this->quality = 87.5;
        $this->oeeForBatch = 79.545454545455;

        $this->testdate = '2019-12-11';
        $this->expectedOee = 0.19;


        $this->prodlistid = 26;

        $this->DateTime1 = new DateTime('11:30:28.420389');
        $this->DateTime2 = new DateTime('11:34:44.772236');
        $this->DateTime3 = new DateTime('11:34:49.624425');
        $this->DateTime4 = new DateTime('11:34:51.630352');
        $this->DateTime5 = new DateTime('11:34:53.630754');

        $this->dteDiff1  = $this->DateTime1->diff($this->DateTime2);
        $this->dteDiff2  = $this->DateTime2->diff($this->DateTime3);
        $this->dteDiff3  = $this->DateTime3->diff($this->DateTime4);
        $this->dteDiff4  = $this->DateTime4->diff($this->DateTime5);

        $this->timeDifference = array(
            0 => array(
                'machinestate' => 'Execute',
                'timeinstate' => $this->dteDiff1
            ),
            1 => array(
                'machinestate' => 'Complete',
                'timeinstate' => $this->dteDiff2
            ),
            2 => array(
                'machinestate' => 'Resetting',
                'timeinstate' => $this->dteDiff3
            ),
            3 => array(
                'machinestate' => 'Idle',
                'timeinstate' => $this->dteDiff4
            ),
            /* 4 => array(
                'machinestate' => 'Execute',
                'timeinstate' => $this->dteDiff5
            ) */
        );

        $this->batchResultOeeForBatch = array(
            0 => array(
                'productid' => 3,
                'acceptedcount' => 700,
                'totalcount' => 800
            )
        );
        $this->idealcycletimeOeeForBatch =  0.3;

        $this->batchResultOeeOneDay = array(
            0 => array(
                'acceptedcount' => 50
            ),
            1 => array(
                'acceptedcount' => 5
            )
        );
        $this->idealcycletimeOeeOneDay = array(
            0 => array(
                'idealcycletime' => 0.3
            ),
            1 => array(
                'idealcycletime' => 0.3
            )
        );
    }


    public function testOEEforOneDay()
    {
        $expected = $this->expectedOee;
        $actual = $this->oeeservice->calculateOeeForOneDay($this->batchResultOeeOneDay, $this->idealcycletimeOeeOneDay);
        $this->assertEquals($expected, $actual);
    }

    public function testCalculationOfAvailabilityCorrectValues()
    {
        $expected = $this->availability;
        $actual = $this->oeeservice->calculateAvailability($this->batchResultOeeForBatch, $this->timeDifference, $this->idealcycletimeOeeForBatch);
        $this->assertEquals($expected, $actual);
    }

    /* public function testCalculationOfAvailabilityInvalidValues()
    {
      
    } */
    public function testCalculationOfPerformanceCorrectValues()
    {
        $expected = $this->performance;
        $actual = $this->oeeservice->calculatePerformance($this->batchResultOeeForBatch, $this->timeDifference, $this->idealcycletimeOeeForBatch);
        $this->assertEquals($expected, $actual);
    }
    /* public function testCalculationOfPerformanceInvalidValues()
    {
      
    } */
    public function testCalculationOfQualityCorrectValues()
    {
        $expected = $this->quality;
        $actual = $this->oeeservice->calculateQuality($this->batchResultOeeForBatch);
        $this->assertEquals($expected, $actual);
    }
    /* public function testCalculationOfQualityInvalidValues()
    {
      
    } */

    public function testCalculationOfOeeForABatchCorrectValues()
    {
        $expected = $this->oeeForBatch;
        $actual = $this->oeeservice->calculateOeeForABatch($this->availability, $this->performance, $this->quality);
        $this->assertEquals($expected, $actual);
    }
    /* public function testCalculationOfOeeForABatchInvalidValues()
    {
      
    } */
}
