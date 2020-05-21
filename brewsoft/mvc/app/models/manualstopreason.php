<?php
/**
 * TODO: error handling
 */
class manualstopreason extends Database {
  public function saveStopReason() {
    var_dump($_POST);
    $productionListId = filter_input(INPUT_POST, "productionListId", FILTER_SANITIZE_STRING);
    $machineid = filter_input(INPUT_POST, "machineID", FILTER_SANITIZE_STRING);
    $sql = "SELECT StopDuringProductionID FROM stopduringproduction WHERE brewerymachineid = :machineid AND productionListId = :productionListId ORDER BY StopDuringProductionID DESC LIMIT 1;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':machineid', $machineid);
    $stmt->bindParam(':productionListId', $productionListId);
    $stmt->execute();
    $stopid = $stmt->fetch(PDO::FETCH_ASSOC);

    $stopReason = filter_input(INPUT_POST, "stopReason", FILTER_SANITIZE_STRING);
      if ($this->getConnection() == null) {
          return false;
          exit();
      } else {
          $sql = "INSERT INTO manualstopreason(reason, productionlistid) VALUES(:stopreason, :listid)";
          try {
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':stopreason', $stopReason);
              $stmt->bindParam(':stopId', $stopid['StopDuringProductionID']);
              $stmt->bindParam(':userid', $_SESSION["userid"]);
              $stmt->execute();
              $lastInsertId = $this->conn->lastInsertID();
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
    $sql = "SELECT m.reason, u.username
            FROM manualstopreason as m,
              StopDuringProduction as s,
              users as u
            WHERE m.StopDuringProductionID = s.StopDuringProductionID
              AND m.userid = u.userid
              AND s.productionlistid = :listid;";
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
