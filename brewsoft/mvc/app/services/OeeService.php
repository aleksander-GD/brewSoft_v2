<?php

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

    public function calculateAvailability($batchResultArray, $sortedTimeInStateList, $idealcycletime)
    {
        $runtime = $this->calculateRuntime($sortedTimeInStateList);
        $plannedproductiontime = $this->plannedProductionTimeForBatch($sortedTimeInStateList);
        /* foreach ($batchResultArray as $batchData) {
            if (is_numeric($batchData['totalcount'])) {
                $idealCycleTimeMultiTotalCount = $batchData['totalcount'] * $idealcycletime;
            } else {
                // error handling
            }
        } */
        $availability = ($runtime / $plannedproductiontime) * 100;

        return $availability;
    }

    private function calculateRuntime($sortedTimeInStateList)
    {
        $runtime = 0;
        $executeTime = 0;
        $total = 0;
        $endTime = 0;

        foreach ($sortedTimeInStateList as $time) {
            $total += $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;

            /* $plannedproductiontime += $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s; */
            if (strtolower($time["machinestate"]) !== 'execute') {
                $seconds = $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;
                $executeTime += $seconds;
            }
        }

        $runtime = $total - $executeTime;

        /* $runtime = (($startTime + $endTime)) - $downTime; */

        return $runtime;
    }

    private function plannedProductionTimeForBatch($sortedTimeInStateList)
    {

        $startTime = 0;
        $endTime = 0;
        $downTime = 0;
        $plannedproductiontime = 0;
        foreach ($sortedTimeInStateList as $time) {

            $plannedproductiontime += $time["timeinstate"]->days * 86400 + $time["timeinstate"]->h * 3600 + $time["timeinstate"]->i * 60 + $time["timeinstate"]->s;
            /* if (strtolower($time["machinestate"]) == 'execute') {
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
            } */
        }
        /* $runtime = (($startTime + $endTime)) - $downTime; */
        print_r($plannedproductiontime);
        return $plannedproductiontime;
    }

    public function getRuntime()
    {
        return $this->runtime;
    }

    public function calculatePerformance($batchResultArray, $sortedTimes, $idealcycletime)
    {
        $runtime = $this->calculateRuntime($sortedTimes);
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
