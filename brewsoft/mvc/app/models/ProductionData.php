<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

  class ProductionData extends Database
  {
    public function getProductionData($productionListID)
    {
      // Only need the production data.
      $sql = "SELECT * FROM productioninfo WHERE productionlistid = :productionListID;";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(':productionListID', $productionListID);
      $stmt->execute();
      $results = $stmt->fetchAll();
      return $results;
    }
  }
?>