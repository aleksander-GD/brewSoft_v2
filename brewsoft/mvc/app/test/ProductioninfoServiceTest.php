<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\ProductionInfoService.php';

class ProductionInfoServiceTest extends TestCase
{

    protected $productionservice;
    protected $valuearray;

    protected function setUp(): void
    {
        $this->productionservice = new ProductionInfoService();
        $this->valuearray = array(
            0 => array(
                'temperature' => 24,
                'humidity' => 10
            ),
            1 => array(
                'temperature' => 23,
                'humidity' => 11
            ),
            2 => array(
                'temperature' => 15,
                'humidity' => 12
            ),
            3 => array(
                'temperature' => 22,
                'humidity' => 2
            )

        );
    }

    public function testLowHumidity()
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
    }

    
}
