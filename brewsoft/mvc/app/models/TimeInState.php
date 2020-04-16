<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class TimeInState extends Database
{

    public function getTimeInStates($productionListID){

        $sql = "SELECT timeinstateid, starttimeinstate, machinestate FROM timeinstate AS ts, machinestate AS ms WHERE productionlistid =" . $productionListID . "AND ts.machinestateid = ms.machinestateid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }

    public function getFirstTimeNextBatch($timeInStateID){
        
        $sql = "SELECT starttimeinstate, machinestate FROM timeinstate AS ts, machinestate AS ms WHERE timeinstateid =" . $timeInStateID . "AND ts.machinestateid = ms.machinestateid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }

}