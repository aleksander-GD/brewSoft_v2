<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class StopReason extends Database
{
    public function getStopReason(){
        
        $sql = "SELECT * 
                FROM stopreason;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchall();
        return $results;
    }

}