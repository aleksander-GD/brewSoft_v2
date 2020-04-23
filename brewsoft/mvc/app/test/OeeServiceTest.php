<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\OeeService.php';
/* require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/OeeService.php'; */

class OeeServiceTest extends TestCase
{

    protected $productionservice;
    protected $availability;
    protected $performance;
    protected $quality;
    protected $oeeForBatch;
    protected $prodlistid;
    protected $timeDifference;

    protected $oeeservice;


    protected function setUp(): void
    {
        $this->oeeservice = new OeeService();
        $this->availability = 108.33333333333;
        $this->performance = 92.307692307692;
        $this->quality = 87.5;
        $this->oeeForBatch = 87.5;

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
        $this->dteDiff5  = $this->DateTime5->diff($this->DateTime6);


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
            4 => array(
                'machinestate' => 'Execute',
                'timeinstate' => $this->dteDiff5
            )
        );
    }

    public function testAvailabilityCorrect()
    {
        $expected = $this->availability;
        $actual = $this->oeeservice->calculateAvailability($this->prodlistid, $this->timeDifference) * 100;
        $this->assertEquals($expected, $actual);
    }
    /* public function testLowHumidity()
    {
        $expected = 2;
        $array = $this->productionservice->getHighLowValues($this->valuearray);
        $actual = $array['minhumid'];
        $this->assertEquals($expected, $actual);
    }

    public function testHighHumidity()
    {
        $expected = 12;
        $array = $this->productionservice->getHighLowValues($this->valuearray);
        $actual = $array['maxhumid'];
        $this->assertEquals($expected, $actual);
    }

    public function testLowTemp()
    {
        $expected = 15;
        $array = $this->productionservice->getHighLowValues($this->valuearray);
        $actual = $array['mintemp'];
        $this->assertEquals($expected, $actual);
    }
    public function testHighTemp()
    {
        $expected = 24;
        $array = $this->productionservice->getHighLowValues($this->valuearray);
        $actual = $array['maxtemp'];
        $this->assertEquals($expected, $actual);
    } */
}
