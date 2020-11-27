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

        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT timeinstateid, starttimeinstate, machinestate 
                FROM timeinstate AS ts, machinestate AS ms 
                WHERE productionlistid = :productionlistid AND ts.machinestateid = ms.machinestateid 
                ORDER BY timeinstateid ASC;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":productionlistid", $productionListID);
                $stmt->execute([$productionListID]);
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getFirstTimeNextBatch($timeInStateID){

        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT timeinstateid, starttimeinstate, machinestate 
                FROM timeinstate AS ts, machinestate AS ms 
                WHERE timeinstateid = :timeinstateid AND ts.machinestateid = ms.machinestateid 
                ORDER BY timeinstateid ASC;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":timeinstateid", $timeInStateID);
                $stmt->execute([$timeInStateID]);
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
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