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

    /* 

    function that checks batch number from database. 

    public function testGetLatestBatchNumber()
    {
        $expected = 66;
        $actual = $this->batchservice->getLatestBatchNumber();
        $this->assertEquals($expected, $actual);
    }
    */
    
    public function testCreateBatchNumber()
    {
        $latestBatchNumber = 65535;
        $expected = 0;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);

        $latestBatchNumber = 0;
        $expected = 1;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);

        $latestBatchNumber = null;
        $expected = 0;
        $actual = $this->batchservice->createBatchNumber($latestBatchNumber);
        $this->assertEquals($expected, $actual);
    }
}
