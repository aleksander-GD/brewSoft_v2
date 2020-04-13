<?php

class TimeInStateService {

    private $timeinstate;
    public function __construct(){
        $this->timeinstate = new TimeInState;
    }
//$times = $this->model('TimeInState')->getTimeInStates($productionlistID);
print_r($times);
echo sizeof($times);
$strStart = $times[0]['starttimeinstate'];
$strEnd = $times[1]['starttimeinstate'];
$dteStart = new DateTime($strStart);
$dteEnd   = new DateTime($strEnd);
$dteDiff  = $dteStart->diff($dteEnd);
print $dteDiff->format("%H:%I:%S");

}