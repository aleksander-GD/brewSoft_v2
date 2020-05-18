<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/TimeInState.php';
class TimeInStateService
{

    // Funktion som får de nødvendige tider og states. 
    public function getTimestampArray($timeArray, $nextBatchFirstState)
    {
        $times = array_merge($timeArray, $nextBatchFirstState);
        return $times;
    }

    public function getDateTimeArray($timeArray, $completiondate)
    {
        $times = $timeArray;
        $count = 0;
        foreach ($timeArray as $key => $value) {
            $times[$key]['starttimeinstate'] = $completiondate['dateofcompletion'] . " " . $value['starttimeinstate'];
            if ($count < sizeof($times) - 1) {
                $times[$key]['endtimeinstate'] = $completiondate['dateofcompletion'] . " " . $times[$key + 1]['starttimeinstate'];
            }
            $count++;
        }
        return array_slice($times, 0, sizeof($times) - 1);
    }




    // Funktion som udregner tiden brugt i hver state
    public function getTimeDifference($mergedArray)
    {
        $times = $mergedArray;
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
                $sorted[$count] = ["machinestate" => $state['machinestate'], "timeinstate" => $state["timeinstate"]];
                $count++;
            } else if (in_array($state["machinestate"], array_column($sorted, 'machinestate'))) {

                $index = array_search($state["machinestate"], array_column($sorted, "machinestate"));

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


                $sorted[$index] = ["machinestate" => $state['machinestate'], "timeinstate" => $result];
            } else {
                $sorted[$count] = ["machinestate" => $state['machinestate'], "timeinstate" => $state["timeinstate"]];
                $count++;
            }
        }

        return $sorted;
    }
}
