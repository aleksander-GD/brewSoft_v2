<?php


class ProductionList extends Database
{
    public function insertBatchToQueue($batchID, $productID, $productAmount, $deadline, $speed, $status)
    {

        $insert_query = 'INSERT INTO ProductionList';
        $values = 'VALUES(:batchID, :productID, :productAmount, :deadline, :speed, :status)';
        $prepare_statement = $this->conn->prepare($insert_query . $values);
        if ($prepare_statement !== false) {

            $prepare_statement->bindParam(':batchID', $batchID);
            $prepare_statement->bindParam(':productID', $productID);
            $prepare_statement->bindParam(':productAmount', $productAmount);
            $prepare_statement->bindParam(':deadline', $deadline);
            $prepare_statement->bindParam(':speed', $speed);
            $prepare_statement->bindParam(':status', $status);

            if ($prepare_statement->execute([$batchID, $productID, $productAmount,  $deadline, $speed, $status])) {
                return true;
            } else {
                return false;
            }
        }
    }
}
