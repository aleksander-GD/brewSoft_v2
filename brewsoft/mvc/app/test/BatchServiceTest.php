<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\BatchService.php';

class BatchServiceTest extends TestCase
{
    private $batchservice;

    protected function setUp(): void
    {
        $this->batchservice = new BatchService();
    }

    public function testBatchNumberStartOver()
    {
        $latestBatchNumber = 65535;
        $expected = 0;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);
    }
    public function testBatchNumberIncrement()
    {
        $latestBatchNumber = 0;
        $expected = 1;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);
    }
    public function testBatchNumberForNull()
    {
        $latestBatchNumber = null;
        $expected = 0;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);
    }
}