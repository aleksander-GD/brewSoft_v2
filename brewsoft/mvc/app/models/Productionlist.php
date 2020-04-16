<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

    class ProductionList extends Database
{
    public function insertBatchToQueue($batchID, $productID, $productAmount, $deadline, $speed, $status)
    {
        $insert_query = 'INSERT INTO productionList (batchID, productID, productAmount, deadline, speed, status)';
        $values = ' VALUES(:batchID, :productID, :productAmount, :deadline, :speed, :status)';
        $prepare_statement = $this->conn->prepare($insert_query . $values);
        if ($prepare_statement !== false) {

            $prepare_statement->bindParam(':batchID', $batchID);
            $prepare_statement->bindParam(':productID', $productID);
            $prepare_statement->bindParam(':productAmount', $productAmount);
            $prepare_statement->bindParam(':deadline', $deadline);
            $prepare_statement->bindParam(':speed', $speed);
            $prepare_statement->bindParam(':status', $status);

            if ($prepare_statement->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editQueuedBatch($productID, $productAmount, $deadline, $speed, $productionListID)
    {
        $sql = "UPDATE productionlist SET productid = :productid, productamount = :productamount ,deadline = :deadline, speed = :speed WHERE productionlistid = :productionlistid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productid', $productID);
        $stmt->bindParam(':productamount', $productAmount);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':speed', $speed);
        $stmt->bindParam(':productionlistid', $productionListID);
        $stmt->execute([$productID, $productAmount, $deadline, $speed, $productionListID]);
    }

    public function getQueuedBatchFromListID($productionlistID)
    {
        $sql = "SELECT * FROM productionlist WHERE productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


    public function getQueuedBatches()
    {
        $sql = "SELECT * FROM productionlist WHERE status = 'queued';";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getLatestBatchNumber()
    {
        $sql = "SELECT * FROM productionlist ORDER BY productionlistID DESC limit 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result["batchid"];
    }

    Public function getProducts()
    {
        $sql = "SELECT productid, productname FROM ProductType";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }
}
