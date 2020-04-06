<?php
require_once '..\core\Database.php';

class ProductionList extends Database
{
    public function insertBatchToQueue($batchID, $productID, $productAmount, $deadline, $speed, $status, $dateofcreation)
    {

        $insert_query = 'INSERT INTO productionList';
        $values = 'VALUES(:batchID, :productID, :productAmount, :deadline, :speed, :status, :dateofcreation)';
        $prepare_statement = $this->conn->prepare($insert_query . $values);
        if ($prepare_statement !== false) {

            $prepare_statement->bindParam(':batchID', $batchID);
            $prepare_statement->bindParam(':productID', $productID);
            $prepare_statement->bindParam(':productAmount', $productAmount);
            $prepare_statement->bindParam(':deadline', $deadline);
            $prepare_statement->bindParam(':speed', $speed);
            $prepare_statement->bindParam(':status', $status);
            $prepare_statement->bindParam(':dateofcreation', $dateofcreation);

            if ($prepare_statement->execute([$batchID, $productID, $productAmount,  $deadline, $speed, $status, $dateofcreation])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getLatestBatchNumber()
    {
        $sql = "SELECT * FROM productionlist ORDER BY productionlistID DESC limit 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result["batchid"];
    }
}
