<?php
//require_once '..\core\Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Finalbatchinformation extends Database
{
    public function getCompletedBatches()
    {
        $sql = "SELECT pl.batchid, fb.* 
                FROM productionlist AS pl, finalbatchinformation as fb
                WHERE pl.productionlistid = fb.productionlistid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getDateOfCompletion($productionlistID)
    {
        $sql = "SELECT dateofcompletion 
                FROM finalbatchinformation
                WHERE productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }

    public function getProductCounts($productionlistID)
    {
        $sql = "SELECT pt.productname, fb.defectcount, fb.acceptedcount 
        FROM producttype AS pt, finalbatchinformation as fb
        WHERE pt.productid = fb.productid AND productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }
}
