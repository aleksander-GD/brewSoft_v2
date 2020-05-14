<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/BatchService.php';

class ProductionList extends Database
{
    private $batchService;
    

    public function __construct()
    {
        parent::__construct();
        $this->batchService = new BatchService();
    }

    public function insertBatchToQueue($productID, $productAmount, $deadline, $speed, $status)
    {
        $tempory_json_file = 'tempbatchfile.json';
        if (!$this->check_database_connection()) {

            $jsonAttributeName['batchID'] = 0;
            $jsonAttributeName['productID'] = $productID;
            $jsonAttributeName['productAmount'] = $productAmount;
            $jsonAttributeName['deadline'] = $deadline;
            $jsonAttributeName['speed'] = $speed;
            $jsonAttributeName['status'] = $status;

            $json_data = json_encode($jsonAttributeName) . "\n";
            file_put_contents($tempory_json_file, $json_data, FILE_APPEND);

            return false;
            exit();
        } else {
            // $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/public/' . 
            $jsonobject = "";

            $this->insertBatchQuery($productID, $productAmount, $deadline, $speed, $status);
            $temp_array = array();
            if (file_exists($tempory_json_file)) {
                $handle = @fopen($tempory_json_file, "r");
                if ($handle) {
                    $insertStatus = true;
                    while (($buffer = fgets($handle)) !== false) {
                        if (!$insertStatus) {
                            array_push($temp_array, $buffer);
                        } else {
                            $jsonobject = json_decode($buffer);
                            $insertStatus = $this->insertBatchQuery(
                                $jsonobject->productID,
                                $jsonobject->productAmount,
                                $jsonobject->deadline,
                                $jsonobject->speed,
                                $jsonobject->status
                            );
                            if (!$insertStatus) {
                                array_push($temp_array, $buffer);
                            }
                        }
                    }
                    if (!feof($handle)) {
                        echo "Error: unexpected fgets() fail\n";
                    }
                    fclose($handle);
                }
                unlink($tempory_json_file);
            }
            if (!empty($temp_array)) {

                foreach ($temp_array as $batchData) {
                    $json_data = $batchData;
                    file_put_contents($tempory_json_file, $json_data, FILE_APPEND);
                }
            }
        }
    }

    private function insertBatchQuery($productID, $productAmount, $deadline, $speed, $status)
    {
        $latestBatchNumber = $this->getLatestBatchNumber();
        $batchID = $this->batchService->createBatchNumber($latestBatchNumber);

        $insert_query = 'INSERT INTO productionList (batchID, productID, productAmount, deadline, speed, status)';
        $values = ' VALUES(:batchID, :productID, :productAmount, :deadline, :speed, :status)';
        if (!$this->check_database_connection()) {
            return false;
        } else {
            try {
                $prepare_statement = $this->conn->prepare($insert_query . $values);
                $prepare_statement->bindParam(':batchID', $batchID);
                $prepare_statement->bindParam(':productID', $productID);
                $prepare_statement->bindParam(':productAmount', $productAmount);
                $prepare_statement->bindParam(':deadline', $deadline);
                $prepare_statement->bindParam(':speed', $speed);
                $prepare_statement->bindParam(':status', $status);
                $prepare_statement->execute();
                return true;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function editQueuedBatch($productID, $productAmount, $deadline, $speed, $productionListID)
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        } else {
            $sql = "UPDATE productionlist SET productid = :productid, productamount = :productamount ,deadline = :deadline, speed = :speed WHERE productionlistid = :productionlistid;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productid', $productID);
                $stmt->bindParam(':productamount', $productAmount);
                $stmt->bindParam(':deadline', $deadline);
                $stmt->bindParam(':speed', $speed);
                $stmt->bindParam(':productionlistid', $productionListID);
                $stmt->execute([$productID, $productAmount, $deadline, $speed, $productionListID]);
                return true;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getQueuedBatchFromListID($productionlistID)
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        }
        $sql = "SELECT * FROM productionlist WHERE productionlistid =" . $productionlistID . ";";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return false;
            exit();
        }
    }

    public function getQueuedBatches()
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        }
        $sql = "SELECT * FROM productionlist WHERE status = 'queued' ORDER BY deadline DESC;";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return false;
            exit();
        }
    }

    public function getCompletedBatches()
    {
        $sql = "SELECT * FROM productionlist WHERE status = 'completed';";
        if (!$this->check_database_connection()) {
            return false;
            exit();
        } else {
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getLatestBatchNumber()
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        }
        $sql = "SELECT batchid FROM productionlist ORDER BY productionlistID DESC limit 1";
        if (!$this->check_database_connection()) {
            return false;
            exit();
        } else {
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetch();

                return $result["batchid"];
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    private function check_database_connection()
    {
        return $this->conn != null;
    }
}
