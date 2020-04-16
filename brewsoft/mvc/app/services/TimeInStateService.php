<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/TimeInState.php';
class TimeInStateService
{

    protected $timeinstate;

    public function __construct()
    {
        $this->timeinstate = new TimeInState;
    }

    // Lav et array med tiden og staten, gentagelser af states tages der ikke højde for
    public function getAllTimeInStates($timeArray, $nextBatchFirstState)
    {
        $times = $timeArray;
        $length = sizeof($times);

        $AllTimeInStatesList = array();

        $count = 0;
        foreach ($times as $time) {
            if ($count < $length - 1) {
                $strStart = $time['starttimeinstate'];
                $strEnd = $times[$count + 1]['starttimeinstate'];
                $dteStart = new DateTime($strStart);
                $dteEnd   = new DateTime($strEnd);
                $dteDiff  = $dteStart->diff($dteEnd);
                $dteDiff->format("%H:%I:%S");

                $AllTimeInStatesList[$count] = ["machinestate" => $time['machinestate'], "timeinstate" => $dteDiff];
                $count++;
            } else if ($count == $length - 1) {

                $strStart = $times[$count]['starttimeinstate'];
                $strEnd = $nextBatchFirstState[0]['starttimeinstate'];
                $dteStart = new DateTime($strStart);
                $dteEnd = new DateTime($strEnd);
                $dteDiff  = $dteStart->diff($dteEnd);
                $dteDiff->format("%H:%I:%S");

                $AllTimeInStatesList[$count] = ["machinestate" => $time['machinestate'], "timeinstate" => $dteDiff];
                $count++;
            }
        }
        return $AllTimeInStatesList;
    }

    // En funktion som lægger gentagende states sammen
    public function getSortedTimeInStates($AllTimeInStatesList)
    {
        $sorted = array();
        $count = 0;
        foreach ($AllTimeInStatesList as $state) {
            if (empty($sorted)) {
                $sorted[$count] = ["machinestate" => $state['machinestate'],"timeinstate" => $state["timeinstate"]];
                $count++;
            
            } else if (in_array($state["machinestate"], array_column($sorted,'machinestate'))) {

                $index = array_search($state["machinestate"],array_column($sorted,"machinestate"));

                $tempoldtime = ($sorted[$index]["timeinstate"]);
                $oldtime = $tempoldtime;

                $newtime = $state["timeinstate"];

                // Create a datetime object and clone it
                $dt = new DateTime();
                $dt_diff = clone $dt;

                // Add the two intervals from before to the first one
                $dt->add($oldtime);
                $dt->add($newtime);

                // The result of the two intervals is now the difference between the datetimeobject and its clone
                $result = $dt->diff($dt_diff);


                $sorted[$index] = ["machinestate" => $state['machinestate'],"timeinstate" => $result];

            } else {
                $sorted[$count] = ["machinestate" => $state['machinestate'],"timeinstate" => $state["timeinstate"]];
                $count++;
            }
        }

        return $sorted;
    }

}
