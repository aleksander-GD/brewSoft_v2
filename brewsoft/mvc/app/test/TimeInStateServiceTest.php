<?php

use PHPUnit\Framework\TestCase;

require_once '..\services\TimeInStateService.php';

class TimeInStateServiceTest extends TestCase
{

    protected $timeInStateService;
    protected $timeArray;
    protected $mergedTimeArray;
    protected $nextBatchFirstTime;
    protected $dateOfCompletion;

    protected function setUp(): void
    {
        $this->timeInStateService = new TimeInStateService();
        $this->timeArray = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => '01:00:00.00',
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => '01:10:00.00',
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => '02:10:00.00',
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => '02:30:00.00',
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => '02:40:00.00',
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => '02:40:01.00',
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => '02:40:02.00',
                'machinestate' => 'Resetting'
            )
        );
        $this->nextBatchFirstTime = array(
            0 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => '02:42:00.00',
                'machinestate' => 'Idle'
            )
        );
        $this->mergedTimeArray = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => '01:00:00.00',
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => '01:10:00.00',
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => '02:10:00.00',
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => '02:30:00.00',
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => '02:40:00.00',
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => '02:40:01.00',
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => '02:40:02.00',
                'machinestate' => 'Resetting'
            ),
            7 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => '02:41:00.00',
                'machinestate' => 'Idle'
            )
        );

        $this->dateOfCompletion = array(
            'dateofcompletion' => '2019-12-04'
        );
    }

    public function testGetTimestampArray()
    {
        $expected = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => '01:00:00.00',
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => '01:10:00.00',
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => '02:10:00.00',
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => '02:30:00.00',
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => '02:40:00.00',
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => '02:40:01.00',
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => '02:40:02.00',
                'machinestate' => 'Resetting'
            ),
            7 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => '02:42:00.00',
                'machinestate' => 'Idle'
            )
        );
        $actual = $this->timeInStateService->getTimestampArray($this->timeArray, $this->nextBatchFirstTime);
        $this->assertEquals($expected, $actual);
    }

    public function testGetDateTimeArray()
    {
        
        $date = '2019-12-04';
        $expected = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' =>  $date . ' 01:00:00.00',
                'machinestate' => 'Idle',
                'endtimeinstate' => $date . ' 01:10:00.00'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' =>  $date . ' 01:10:00.00',
                'machinestate' => 'Executing',
                'endtimeinstate' => $date . ' 02:10:00.00'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' =>  $date . ' 02:10:00.00',
                'machinestate' => 'Held',
                'endtimeinstate' => $date . ' 02:30:00.00'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' =>  $date . ' 02:30:00.00',
                'machinestate' => 'Executing',
                'endtimeinstate' => $date . ' 02:40:00.00'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' =>  $date . ' 02:40:00.00',
                'machinestate' => 'Completing',
                'endtimeinstate' => $date . ' 02:40:01.00'

            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => $date . ' 02:40:01.00',
                'machinestate' => 'Complete',
                'endtimeinstate' => $date . ' 02:40:02.00'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' =>  $date . ' 02:40:02.00',
                'machinestate' => 'Resetting',
                'endtimeinstate' => $date . ' 02:41:00.00'
            )
        );
        $actual = $this->timeInStateService->getDateTimeArray($this->mergedTimeArray, $this->dateOfCompletion);
        $this->assertEquals($expected, $actual);
    }

    public function testGetTimeDifference()
    {
        $time1 = new DateTime('01:00:00.00');
        $time2 = new DateTime('01:10:00.00');
        $time3 = new DateTime('02:10:00.00');
        $time4 = new DateTime('02:30:00.00');
        $time5 = new DateTime('02:40:00.00');
        $time6 = new DateTime('02:40:01.00');
        $time7 = new DateTime('02:40:02.00');
        $time8 = new DateTime('02:41:00.00');
        $dteDiff1  = $time1->diff($time2);
        $dteDiff2  = $time2->diff($time3);
        $dteDiff3  = $time3->diff($time4);
        $dteDiff4  = $time4->diff($time5);
        $dteDiff5  = $time5->diff($time6);
        $dteDiff6  = $time6->diff($time7);
        $dteDiff7  = $time7->diff($time8);

        $expected = array(
            0 => array(
                'machinestate' => 'Idle',
                'timeinstate' => $dteDiff1
            ),
            1 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $dteDiff2
            ),
            2 => array(
                'machinestate' => 'Held',
                'timeinstate' => $dteDiff3,
            ),
            3 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $dteDiff4
            ),
            4 => array(
                'machinestate' => 'Completing',
                'timeinstate' => $dteDiff5
            ),
            5 => array(
                'machinestate' => 'Complete',
                'timeinstate' => $dteDiff6
            ),
            6 => array(
                'machinestate' => 'Resetting',
                'timeinstate' => $dteDiff7
            )
        );
        $actual = $this->timeInStateService->getTimeDifference($this->mergedTimeArray);
        $this->assertEquals($expected, $actual);
    }


}
