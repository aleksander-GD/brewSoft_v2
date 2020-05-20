<?php
class manualstopreason extends Database {
  public function saveStopReason() {
    /**
     * TODO: Write the functionality to get the productionlistid from somewhere
     */
    $stopReason = filter_input(INPUT_POST, "stopReason", FILTER_SANITIZE_STRING);
      if ($this->getConnection() == null) {
          return false;
          exit();
      } else {
          $sql = "INSERT INTO manualstopreason(reason, productionlistid) VALUES(:stopreason, :listid)";
          try {
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':stopreason', $stopReason);
              $stmt->bindParam(':listid', $listid);
              $stmt->execute();
              $lastInsertId = $stmt->lastInsertId();
          } catch (PDOException $e) {
              return false;
              exit();
          }
      }
  }

  public function getStopReasonsForProduction($productionListID) {
      if ($this->getConnection() == null) {
          return false;
          exit();
      } else {
          $sql = "SELECT reason FROM manualstopreason WHERE productionlistid = :listid;";
          try {
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':listid', $productionListID);
              $stmt->execute();
              return $stmt->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {
              return false;
              exit();
          }
      }
  }
}
