<?php
/**
 * TODO: error handling
 */
class manualstopreason extends Database {
  public function saveStopReason() {
    $sql = "SELECT StopDuringProductionID FROM stopduringproduction WHERE brewerymachineid = :machineid ORDER BY StopDuringProductionID LIMIT 1;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':machineid', $machineid);
    $stmt->execute();
    $stopid = $stmt->fetch(PDO::FETCH_ASSOC);

    $stopReason = filter_input(INPUT_POST, "stopReason", FILTER_SANITIZE_STRING);
    $sql = "INSERT INTO manualstopreason(reason, StopDuringProductionID, userid) VALUES(:stopreason, :stopId, :userid);";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':stopreason', $stopReason);
    $stmt->bindParam(':stopId', $stopid['StopDuringProductionID']);
    $stmt->bindParam(':userid', $_SESSION["userid"]);
    $stmt->execute();
    $lastInsertId = $this->conn->lastInsertID();
  }

  public function getStopReasonsForProduction($productionListID) {
    $sql = "SELECT m.reason, u.username
            FROM manualstopreason as m,
              StopDuringProduction as s,
              users as u
            WHERE m.StopDuringProductionID = s.StopDuringProductionID
              AND m.userid = u.userid
              AND s.productionlistid = :listid;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':listid', $productionListID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
