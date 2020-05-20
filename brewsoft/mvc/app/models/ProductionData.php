<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

  class ProductionData extends Database
  {
    public function StartProduction()
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT *
              FROM productionlist
              WHERE status = 'queued'
              ORDER BY deadline ASC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function MachineData($productionListID, $machineID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT pi.*, md.*
              FROM productioninfo AS pi, machinedata AS md
              WHERE pi.productionlistid = :productionListID
                AND md.brewerymachineid = :machineid
              ORDER BY timestamp DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionListID', $productionListID);
                $stmt->bindParam(':machineid', $machineID);
                $stmt->execute();
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function ProductionStop($productionListID, $machineID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT stopreasonid
              FROM stopduringproduction
              WHERE productionlistid = :productionListID
                AND brewerymachineid = :machineid
              ORDER BY timestamp DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionListID', $productionListID);
                $stmt->bindParam(':machineid', $machineID);
                $stmt->execute();
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function ingredientsUpdate($machineID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT *
              FROM ingredientsUpdate
              WHERE brewerymachineid = :machineID
              ORDER BY timestamp DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':machineID', $machineID);
                $stmt->execute();
                $results = $stmt - fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function ProducedData($productionListID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT *
              FROM productiondata
              WHERE productionlistid = :productionlistid
              ORDER BY timestamp DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindPara(':productionlistid', $productionListID);
                $stmt->execute();
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }
  }
?>