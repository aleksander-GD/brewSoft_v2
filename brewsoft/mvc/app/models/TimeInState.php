<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class TimeInState extends Database
{

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

}