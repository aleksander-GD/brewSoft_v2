<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class TimeInState extends Database
{

    public function getTimeInStates($productionListID){

        $sql = "SELECT * FROM timeinstate WHERE productionlistid =" . $productionListID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }

}