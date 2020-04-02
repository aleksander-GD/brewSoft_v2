<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\BatchService.php';

class BatchServiceTest extends TestCase
{
    private $batchservice;
    
    protected function setUp() : void
    {
        $this->batchservice = new BatchService();
    }
    
    
    public function testIncrementBatchNumber()
    {
        $latestBatchNumber = 65535;
        $expected = 0;
        $actual = $this->batchservice->incrementBatchNumber($latestBatchNumber);
        $this->assertEquals($expected,$actual);
        
        $latestBatchNumber = 0;
        $expected = 1;
        $actual = $this->batchservice->incrementBatchNumber($latestBatchNumber);
        $this->assertEquals($expected,$actual);
        
        $latestBatchNumber = null;
        $expected = 0;
        $actual = $this->batchservice->incrementBatchNumber($latestBatchNumber);
        $this->assertEquals($expected,$actual);

    }
    
}
?>