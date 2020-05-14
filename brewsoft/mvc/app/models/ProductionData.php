<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

  class ProductionData extends Database
  {
    public function StartProduction()
    {
      $sql = "SELECT *
              FROM productionlist
              WHERE status = 'queued'
              ORDER BY deadline ASC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

    public function MachineData($productionListID, $machineID)
    {
      $sql = "SELECT pi.*, md.*
              FROM productioninfo AS pi, machinedata AS md
              WHERE pi.productionlistid = :productionListID
                AND md.brewerymachineid = :machineid
              ORDER BY timestamp DESC LIMIT 1;";
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
              ORDER BY timestamp DESC LIMIT 1;";
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
              ORDER BY timestamp DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':machineID', $machineID);
      $stmt->execute();
      $results = $stmt-fetch();
      return $results;
    }

    public function ProducedData($productionListID)
    {
      $sql = "SELECT *
              FROM productiondata
              WHERE productionlistid = :productionlistid
              ORDER BY timestamp DESC LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindPara(':productionlistid', $productionListID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }

  }
?>