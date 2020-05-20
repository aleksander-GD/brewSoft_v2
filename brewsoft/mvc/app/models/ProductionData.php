<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

  class ProductionData extends Database
  {
    // TODO: Changes so it checks for stopped batches or gets this data from the Java part.
    // Get data from machine somehow?
    // What about resumed batches?
    public function StartProduction($machineId, $productionListID)
    {
      $sql = "SELECT *
              FROM productionlist
              WHERE productionlistid = :listid AND machineid = :machineid AND status = 'In Production'
              ORDER BY deadline ASC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':machineid', $machineId);
      $stmt->bindParam(':listid', $productionListID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

    public function MachineData($productionListID, $machineID)
    {
      $sql = "SELECT pi.*, md.*
              FROM productioninfo AS pi, machinedata AS md
              WHERE pi.productionlistid = :productionListID
                AND pi.brewerymachineid = :machineid
                AND pi.entrydate = md.entrydate
                AND md.brewerymachineid = pi.brewerymachineid
              ORDER BY pi.entrytime DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':productionListID', $productionListID);
      $stmt->bindParam(':machineid', $machineID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

    public function ProductionStop($productionListID, $machineID)
    {
      $sql = "SELECT stopreasonid
              FROM stopduringproduction
              WHERE productionlistid = :productionListID
                AND brewerymachineid = :machineid
              ORDER BY entrytime DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':productionListID', $productionListID);
      $stmt->bindParam(':machineid', $machineID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

    public function ingredientsUpdate($machineID)
    {
      $sql = "SELECT *
              FROM ingredientsUpdate
              WHERE brewerymachineid = :machineID
              ORDER BY entrytime DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':machineID', $machineID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

    public function ProducedData($productionListID)
    {
      $sql = "SELECT *
              FROM produceddata
              WHERE productionlistid = :productionlistid
              ORDER BY entrytime DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':productionlistid', $productionListID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

  }
