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


    public function MachineData($productionListID)
    {
      $sql = "SELECT pi.humidity, pi.temperature
              FROM productioninfo AS pi
              WHERE pi.productionlistid = :productionListID
              LIMIT 1;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':productionListID', $productionListID);
      $stmt->execute();
      $results = $stmt->fetch();
      return $results;
    }


  }
?>