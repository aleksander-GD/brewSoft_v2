<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\StopReasonService.php';

class StopReasonServiceTest extends TestCase
{
    protected $stopReasonService;
    protected $stopReasonArray;

    protected function setUp(): void
    {
        $this->stopReasonService = new StopReasonService();
        
        $this->stopReasonArray = array( 
            0 => array(
                'stopreasonid' => 10, 
                'reason' => 'Empty inventory'
            ), 
            1 => array( 
                'stopreasonid' => 11, 
                'reason' => 'Maintenance'
            ), 
            2 => array(
                'stopreasonid' => 12, 
                'reason' => 'Manual Stop' 
            ), 
            3 => array( 
                'stopreasonid' => 13, 
                'reason' => 'Motor power loss'
            ), 
            4 => array( 
                'stopreasonid' => 14, 
                'reason' => 'Manual abort' 
            ));
    }

    public function testGetStopReason(){
        $expected = 'Maintenance';
        $actual = $this->stopReasonService->getStopReason($this->stopReasonArray,11);
        
        $this->assertEquals($expected, $actual);
    }


}