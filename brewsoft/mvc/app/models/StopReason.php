<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class StopReason extends Database
{
    public function getStopReason($ID){
        
        $sql = "SELECT reason 
                FROM stopreason 
                Where stopreasonid = $ID;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['reason'];
    }

}