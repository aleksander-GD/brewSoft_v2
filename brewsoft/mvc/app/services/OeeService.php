<?php

require_once 'TimeInStateService.php';
class OeeService
{
    private $dateofcompletion;
    private $finalbatchinformationModel;
    private $plannedProductionTime;
    private $timeinstateModel;
    private $timeInStateService;
    private $runtime;
    private $producttypeModel;

    public function __construct()
    {
        $this->dateofcompletion = filter_input(INPUT_POST, "dateofcompletion", FILTER_SANITIZE_STRING);
        $this->timeInStateService = new TimeInStateService();
        $this->plannedProductionTime = 28800;
    }
    public function getDateOfCompletion()
    {
        return $this->dateofcompletion;
    }
    public function calculateOeeForOneDay($batchResults, $idealCycleTime)
    {
        $oee = 0;
        foreach ($batchResults as $batchData) {
            if (is_numeric($batchData['acceptedcount'])) {
                $oee += $batchData['acceptedcount'] + $idealCycleTime[0]['idealcycletime'];
            } else {
                // error handling
            }
        }

        $calculateOee = ($oee / $this->plannedProductionTime) * 100;

        return round($calculateOee, 2);
    }

    public function calculateAvailability($batchResultArray, $timeDifference, $idealcycletime)
    {
        $runtime = $this->calculateRuntime($timeDifference);
        foreach ($batchResultArray as $batchData) {
            if (is_numeric($batchData['totalcount'])) {
                $idealCycleTimeMultiTotalCount = $batchData['totalcount'] * $idealcycletime;
            } else {
                // error handling
            }
        }
        $availability = ($runtime / ($idealCycleTimeMultiTotalCount)) * 100;

        return $availability;
    }
    private function calculateRuntime($timeDifference)
    {
        $sortedTimes = $this->timeInStateService->getSortedTimeInStates($timeDifference);

        $startTime = 0;
        $endTime = 0;
        $downTime = 0;

        foreach ($sortedTimes as $time) {

            if (strtolower($time["machinestate"]) == 'execute') {
                $seconds = $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;
                $startTime = $seconds;
            }
            if (strtolower($time["machinestate"]) == 'complete') {
                $seconds = $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;
                $endTime = $seconds;
            }
            if (strtolower($time["machinestate"]) == 'held') {
                $seconds = $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;
                $downTime = $seconds;
            }
        }
        $runtime = (($startTime + $endTime)) - $downTime;
        return $runtime;
    }

    public function getRuntime()
    {
        return $this->runtime;
    }

    public function calculatePerformance($batchResultArray, $timeDifference, $idealcycletime)
    {
        $runtime = $this->calculateRuntime($timeDifference);
        foreach ($batchResultArray as $batchData) {
            if (is_numeric($batchData['totalcount'])) {
                $idealCycleTimeMultiTotalCount = $batchData['totalcount'] * $idealcycletime;
            } else {
                // error handling
            }
        }

        $performance = ($idealCycleTimeMultiTotalCount / $runtime) * 100;

        return $performance;
    }

    public function calculateQuality($batchResultArray)
    {
        $quality = 0;
        foreach ($batchResultArray as $batchData) {
            if (is_numeric($batchData['totalcount']) && is_numeric($batchData['acceptedcount'])) {
                $quality = ($batchData['acceptedcount'] / $batchData['totalcount']) * 100;
            } else {
                // error handling
            }
        }

        return $quality;
    }

    public function calculateOeeForABatch($availability, $performance, $quality)
    {
        $oee = (($availability / 100) * ($performance / 100) * ($quality / 100)) * 100;
        return $oee;
    }
}
