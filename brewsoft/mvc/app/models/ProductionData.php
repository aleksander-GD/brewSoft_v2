<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

  class ProductionData extends Database
  {
    // TODO: Changes so it checks for stopped batches or gets this data from the Java part.
    // Get data from machine somehow?
    // What about resumed batches?
    public function StartProduction($machineId, $productionListID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT *
              FROM productionlist
              WHERE productionlistid = :listid AND machineid = :machineid AND status = 'In Production'
              ORDER BY deadline ASC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':machineid', $machineId);
                $stmt->bindParam(':listid', $productionListID);
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
                AND pi.brewerymachineid = :machineid
                AND pi.entrydate = md.entrydate
                AND md.brewerymachineid = pi.brewerymachineid
              ORDER BY pi.entrytime DESC LIMIT 1;";
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
              ORDER BY entrytime DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionListID', $productionListID);
                $stmt->bindParam(':machineid', $machineID);
                $stmt->execute();
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                exit();
                return false;
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
              ORDER BY entrytime DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':machineID', $machineID);
                $stmt->execute();
                $results = $stmt->fetch();
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
              FROM produceddata
              WHERE productionlistid = :productionlistid
              ORDER BY (entrydate, entrytime) DESC LIMIT 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistid', $productionListID);
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
