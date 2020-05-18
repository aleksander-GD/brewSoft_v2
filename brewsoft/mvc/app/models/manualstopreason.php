<?php
class manualstopreason extends Database {
  public function saveStopReason() {
    /**
     * TODO: Write the functionality to get the productionlistid from somewhere
     */
    $stopReason = filter_input(INPUT_POST, "stopReason", FILTER_SANITIZE_STRING);
    $sql = "INSERT INTO manualstopreason(reason, productionlistid) VALUES(:stopreason, :listid)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':stopreason', $stopReason);
    $stmt->bindParam(':listid', $listid);
    $stmt->execute();
    $lastInsertId = $stmt->lastInsertId();
  }

  public function getStopReasonsForProduction($productionListID) {
    $sql = "SELECT reason FROM manualstopreason WHERE productionlistid = :listid;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':listid', $productionListID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
