<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class StopReason extends Database
{
    public function getStopReason($ID){
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT reason 
                FROM stopreason 
                Where stopreasonid = :id;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $ID);
                $stmt->execute($ID);
                $result = $stmt->fetch();
                return $result['reason'];
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

}