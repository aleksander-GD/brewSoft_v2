<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Productioninfo extends Database
{
    public function getTempAndHumid($productionlistID){
        $sql = "SELECT temperature, humidity 
                FROM productioninfo
                WHERE productionlistid =" . $productionlistID . "
                ORDER BY productioninfoid ASC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchall();
        return $results;
    }
}