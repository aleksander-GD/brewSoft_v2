<?php

class TimeInStateService
{

    private $timeinstate;

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
        if ($count < $length - 1) {
            foreach ($times as $time) {
                $strStart = $time['starttimeinstate'];
                $strEnd = $times[$count + 1]['starttimeinstate'];
                $dteStart = new DateTime($strStart);
                $dteEnd   = new DateTime($strEnd);
                $dteDiff  = $dteStart->diff($dteEnd);
                $dteDiff->format("%H:%I:%S");

                $AllTimeInStatesList->array_push(array($count, $time['machinestate'], $dteDiff));
                $count++;
            }
        } else if ($count == $length - 1) {
            $strStart = $times[$count]['starttimeinstate'];
            $strEnd = $nextBatchFirstState[0]['starttimeinstate'];
            $dteStart = new DateTime($strStart);
            $dteEnd   = new DateTime($strEnd);
            $dteDiff  = $dteStart->diff($dteEnd);
            $dteDiff->format("%H:%I:%S");

            $AllTimeInStatesList->array_push(array($count, $time['machinestate'], $dteDiff));
            $count++;
        }

        return $AllTimeInStatesList;

        /*         print_r($times);
        echo sizeof($times);
        $strStart = $times[0]['starttimeinstate'];
        $strEnd = $times[1]['starttimeinstate'];
        $dteStart = new DateTime($strStart);
        $dteEnd   = new DateTime($strEnd);
        $dteDiff  = $dteStart->diff($dteEnd);
        print $dteDiff->format("%H:%I:%S"); */
    }

    // En funktion som lægger gentagende states sammen
    public function getSortedTimeInStates($AllTimeInStatesList)
    {
    }

    //evt funktion som fjerne dem som vi ikke vil have med?
}
