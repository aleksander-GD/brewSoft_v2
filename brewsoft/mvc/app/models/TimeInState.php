<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/TimeInStateService.php';


class TimeInState extends Database
{
    protected $timeservice;
    public function __construct()
    {
        parent::__construct();
        $this->timeService = new TimeInStateService();
    }

    public function getTimeInStates($productionListID){

        $sql = "SELECT timeinstateid, starttimeinstate, machinestate 
                FROM timeinstate AS ts, machinestate AS ms 
                WHERE productionlistid =" . $productionListID . "AND ts.machinestateid = ms.machinestateid 
                ORDER BY timeinstateid ASC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }

    public function getFirstTimeNextBatch($timeInStateID){
        
        $sql = "SELECT timeinstateid, starttimeinstate, machinestate 
                FROM timeinstate AS ts, machinestate AS ms 
                WHERE timeinstateid =" . $timeInStateID . "AND ts.machinestateid = ms.machinestateid 
                ORDER BY timeinstateid ASC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }
    
    public function sortedTimeStates($productionListID){
        $timeArray = $this->getTimeInStates($productionListID);
        $length = sizeof($timeArray) - 1;
        $nextBatchTimeInStateID = $timeArray[$length]['timeinstateid'] + 1;
        $nextBatchFirstTime = $this->getFirstTimeNextBatch($nextBatchTimeInStateID);
        $timestampArray = $this->timeService->getTimestampArray($timeArray, $nextBatchFirstTime);
        $allTimesInStateList = $this->timeService->getTimeDifference($timestampArray);
        $sortedTimeInStateList = $this->timeService->getSortedTimeInStates($allTimesInStateList);
        
        return $sortedTimeInStateList;
    }

    public function getDateTimeArray($timeInStateArray, $completionDate)
    {
        $dateTimeArray = $this->timeService->getDateTimeArray($timeInStateArray, $completionDate);
        return $dateTimeArray;
    }
}