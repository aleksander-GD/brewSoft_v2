<?php
class MachineList extends Database {

  public function getMachineList() {
    $sql = "SELECT * FROM brewerymachine;";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
