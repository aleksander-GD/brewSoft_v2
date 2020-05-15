<?php
class manualstopreason extends Database {
  public function saveStopReason() {
    $stopReason = filter_input(INPUT_POST, "stopReason", FILTER_SANITIZE_STRING);
    $sql = "INSERT INTO manualstopreason(stopreason) VALUES(:stopreason)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':stopreason', $stopReason);
    $stmt->execute();
    $lastInsertId = $stmt->lastInsertID();
  }

  public function getStopReasonsForProduction($productionListID) {
    $sql = "SELECT stopreason FROM manualstopreason WHERE productionlistid = :listid;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':listid', $productionListID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
