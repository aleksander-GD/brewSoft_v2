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
    protected $time1;
    protected $time2;
    protected $time3;
    protected $time4;
    protected $time5;
    protected $time6;
    protected $time7;    
    protected $time8;
    protected $DateTime1;
    protected $DateTime2;
    protected $DateTime3;
    protected $DateTime4;
    protected $DateTime5;
    protected $DateTime6;
    protected $DateTime7;
    protected $DateTime8;
    protected $dteDiff1;
    protected $dteDiff2;
    protected $dteDiff3;
    protected $dteDiff4;
    protected $dteDiff5;
    protected $dteDiff6;
    protected $dteDiff7;
    protected $timeinstatearray;

    protected function setUp(): void
    {
        $this->timeInStateService = new TimeInStateService();
        $this->time1 = '01:00:00.00';
        $this->time2 = '01:10:00.00';
        $this->time3 = '02:10:00.00';
        $this->time4 = '02:30:00.00';
        $this->time5 = '02:40:00.00';
        $this->time6 = '02:40:01.00';
        $this->time7 = '02:40:02.00';
        $this->time8 = '02:41:00.00';
        $this->DateTime1 = new DateTime('01:00:00.00');
        $this->DateTime2 = new DateTime('01:10:00.00');
        $this->DateTime3 = new DateTime('02:10:00.00');
        $this->DateTime4 = new DateTime('02:30:00.00');
        $this->DateTime5 = new DateTime('02:40:00.00');
        $this->DateTime6 = new DateTime('02:40:01.00');
        $this->DateTime7 = new DateTime('02:40:02.00');
        $this->DateTime8 = new DateTime('02:41:00.00');
        $this->timeArray = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => $this->time1,
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => $this->time2,
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => $this->time3,
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => $this->time4,
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => $this->time5,
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => $this->time6,
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => $this->time7,
                'machinestate' => 'Resetting'
            )
        );
        $this->nextBatchFirstTime = array(
            0 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => $this->time8,
                'machinestate' => 'Idle'
            )
        );
        $this->mergedTimeArray = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => $this->time1,
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => $this->time2,
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => $this->time3,
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => $this->time4,
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => $this->time5,
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => $this->time6,
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => $this->time7,
                'machinestate' => 'Resetting'
            ),
            7 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => $this->time8,
                'machinestate' => 'Idle'
            )
        );

        $this->dateOfCompletion = array(
            'dateofcompletion' => '2019-12-04'
        );
        $this->dteDiff1  = $this->DateTime1->diff($this->DateTime2);
        $this->dteDiff2  = $this->DateTime2->diff($this->DateTime3);
        $this->dteDiff3  = $this->DateTime3->diff($this->DateTime4);
        $this->dteDiff4  = $this->DateTime4->diff($this->DateTime5);
        $this->dteDiff5  = $this->DateTime5->diff($this->DateTime6);
        $this->dteDiff6  = $this->DateTime6->diff($this->DateTime7);
        $this->dteDiff7  = $this->DateTime7->diff($this->DateTime8);
        
        $this->timeinstatearray = array(
            0 => array(
                'machinestate' => 'Idle',
                'timeinstate' => $this->dteDiff1
            ),
            1 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $this->dteDiff2
            ),
            2 => array(
                'machinestate' => 'Held',
                'timeinstate' => $this->dteDiff3
            ),
            3 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $this->dteDiff4
            ),
            4 => array(
                'machinestate' => 'Completing',
                'timeinstate' => $this->dteDiff5
            ),
            5 => array(
                'machinestate' => 'Complete',
                'timeinstate' => $this->dteDiff6
            ),
            6 => array(
                'machinestate' => 'Resetting',
                'timeinstate' => $this->dteDiff7
            )
        );

    }

    public function testGetTimestampArray()
    {
        $expected = array(
            0 => array(
                'timeinstateid' => 1,
                'starttimeinstate' => $this->time1,
                'machinestate' => 'Idle'
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' => $this->time2,
                'machinestate' => 'Executing'
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' => $this->time3,
                'machinestate' => 'Held'
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' => $this->time4,
                'machinestate' => 'Executing'
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' => $this->time5,
                'machinestate' => 'Completing'
            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => $this->time6,
                'machinestate' => 'Complete'
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' => $this->time7,
                'machinestate' => 'Resetting'
            ),
            7 => array(
                'timeinstateid' => 8,
                'starttimeinstate' => $this->time8,
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
                'starttimeinstate' =>  $date . " ". $this->time1,
                'machinestate' => 'Idle',
                'endtimeinstate' => $date . " ". $this->time2
            ),
            1 => array(
                'timeinstateid' => 2,
                'starttimeinstate' =>  $date . " ". $this->time2,
                'machinestate' => 'Executing',
                'endtimeinstate' => $date . " ". $this->time3
            ),
            2 => array(
                'timeinstateid' => 3,
                'starttimeinstate' =>  $date . " ". $this->time3,
                'machinestate' => 'Held',
                'endtimeinstate' => $date . " ". $this->time4
            ),
            3 => array(
                'timeinstateid' => 4,
                'starttimeinstate' =>  $date . " ". $this->time4,
                'machinestate' => 'Executing',
                'endtimeinstate' => $date . " ". $this->time5
            ),
            4 => array(
                'timeinstateid' => 5,
                'starttimeinstate' =>  $date . " ". $this->time5,
                'machinestate' => 'Completing',
                'endtimeinstate' => $date . " ". $this->time6

            ),
            5 => array(
                'timeinstateid' => 6,
                'starttimeinstate' => $date . " ". $this->time6,
                'machinestate' => 'Complete',
                'endtimeinstate' => $date . " ". $this->time7
            ),
            6 => array(
                'timeinstateid' => 7,
                'starttimeinstate' =>  $date . " ". $this->time7,
                'machinestate' => 'Resetting',
                'endtimeinstate' => $date . " ". $this->time8
            )
        );
        $actual = $this->timeInStateService->getDateTimeArray($this->mergedTimeArray, $this->dateOfCompletion);
        $this->assertEquals($expected, $actual);
    }

    public function testGetTimeDifference()
    {
        $expected = array(
            0 => array(
                'machinestate' => 'Idle',
                'timeinstate' => $this->dteDiff1
            ),
            1 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $this->dteDiff2
            ),
            2 => array(
                'machinestate' => 'Held',
                'timeinstate' => $this->dteDiff3
            ),
            3 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $this->dteDiff4
            ),
            4 => array(
                'machinestate' => 'Completing',
                'timeinstate' => $this->dteDiff5
            ),
            5 => array(
                'machinestate' => 'Complete',
                'timeinstate' => $this->dteDiff6
            ),
            6 => array(
                'machinestate' => 'Resetting',
                'timeinstate' => $this->dteDiff7
            )
        );
        $actual = $this->timeInStateService->getTimeDifference($this->mergedTimeArray);
        $this->assertEquals($expected, $actual);
    }

    public function testGetSortedTimeInStates(){

        $dt = new DateTime();
        $dt_diff = clone $dt;

        $dt->add($this->dteDiff2);
        $dt->add($this->dteDiff4);

        $result = $dt->diff($dt_diff);

        $expected = array(
            0 => array(
                'machinestate' => 'Idle',
                'timeinstate' => $this->dteDiff1
            ),
            1 => array(
                'machinestate' => 'Executing',
                'timeinstate' => $result
            ),
            2 => array(
                'machinestate' => 'Held',
                'timeinstate' => $this->dteDiff3,
            ),

            3 => array(
                'machinestate' => 'Completing',
                'timeinstate' => $this->dteDiff5
            ),
            4 => array(
                'machinestate' => 'Complete',
                'timeinstate' => $this->dteDiff6
            ),
            5 => array(
                'machinestate' => 'Resetting',
                'timeinstate' => $this->dteDiff7
            )
        );
        $actual = $this->timeInStateService->getSortedTimeInStates($this->timeinstatearray);
        $this->assertEquals($expected, $actual);



    }


}
