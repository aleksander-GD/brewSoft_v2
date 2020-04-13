<?php

class TimeInStateService
{

    private $timeinstate;

    public function __construct()
    {
        $this->timeinstate = new TimeInState;
    }

    // Lav et array med tiden og staten, gentagelser af states tages der ikke højde for
    public function getAllTimeInStates($productionlistid)
    {
        $times = $this->timeinstate->getTimeInStates($productionlistid);
        print_r($times);
        echo sizeof($times);
        $strStart = $times[0]['starttimeinstate'];
        $strEnd = $times[1]['starttimeinstate'];
        $dteStart = new DateTime($strStart);
        $dteEnd   = new DateTime($strEnd);
        $dteDiff  = $dteStart->diff($dteEnd);
        print $dteDiff->format("%H:%I:%S");
    }

    // En funktion som lægger gentagende states sammen
    public function getSortedTimeInStates($AllTimeInStatesList){

    }

    //evt funktion som fjerne dem som vi ikke vil have med?
}
