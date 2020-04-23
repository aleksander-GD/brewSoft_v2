<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/Finalbatchinformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/TimeInState.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/Productionlist.php';

class OeeService
{
    private $dateofcompletion;
    private $finalbatchinformationModel;
    private $plannedProductionTime;
    private $timeinstateModel;
    private $timeInStateService;
    private $runtime;
    // importere glumbys

    public function __construct()
    {
        $this->dateofcompletion = filter_input(INPUT_POST, "dateofcompletion", FILTER_SANITIZE_STRING);
        //$this->dateofcompletion = "2019-12-04"; // For test

        $this->finalbatchinformationModel = new Finalbatchinformation();
        $this->timeInStateService = new TimeInStateService();
        $this->timeinstateModel = new TimeInState();
        $this->plannedProductionTime = 28800;
    }

    public function calculateOeeForOneDay()
    {
        $batchResults = $this->finalbatchinformationModel->getAcceptedAndTotalCount($this->dateofcompletion);

        $oee = 0;
        foreach ($batchResults as $batchData) {
            if (is_numeric($batchData['acceptedcount']) && is_numeric($batchData['idealcycletime'])) {
                $oee += $batchData['acceptedcount'] + $batchData['idealcycletime'];
            } else {
                // error handling
            }
        }

        $calculateOee = ($oee / $this->plannedProductionTime) * 100;

        return $calculateOee;
    }

    public function calculateAvailability($productionListid, $timeDifference)
    {
        $runtime = $this->calculateRuntime($productionListid, $timeDifference);

        $availability = $runtime / $this->plannedProductionTime;

        return $availability;
    }
    private function calculateRuntime($productionListid, $timeDifference)
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
        $this->runtime = (($startTime + $endTime)) - $downTime;
        //$this->runtime = ($startTime + $endTime) - $downTime;
        return $this->runtime;
    }

    public function calculatePerformance($productionListid)
    {
        $batchResults = $this->finalbatchinformationModel->getAcceptedAndTotalCountForProdID($productionListid);

        foreach ($batchResults as $batchData) {
            if (is_numeric($batchData['totalcount']) && is_numeric($batchData['idealcycletime'])) {
                $idealCycleTimeMultiTotalCount = $batchData['totalcount'] * $batchData['idealcycletime'];
            } else {
                // error handling
            }
        }

        $performance = $idealCycleTimeMultiTotalCount / $this->runtime;

        return $performance;
    }

    public function calculateQuality($productionListid)
    {
        $batchResults = $this->finalbatchinformationModel->getAcceptedAndTotalCountForProdID($productionListid);

        $quality = 0;
        foreach ($batchResults as $batchData) {
            if (is_numeric($batchData['totalcount']) && is_numeric($batchData['acceptedcount'])) {
                $quality = $batchData['totalcount'] / $batchData['acceptedcount'];
            } else {
                // error handling
            }
        }

        return $quality;
    }

    public function calculateOeeForABatch($availability, $performance, $quality)
    {
        // oee of 0.047677519379845 for productionlistid 30 thats 4,7 %, is that correct?
        //$oee = $this->calculateAvailability($productionListid, $timeDifference) * $this->calculatePerformance($productionListid) * $this->calculateQuality($productionListid);
        $oee = $availability * $performance * $quality;
        return $oee;
    }
}
