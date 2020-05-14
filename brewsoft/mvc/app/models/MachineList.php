<?php
class MachineList extends Database {

  public function getMachineList() {
    $sql = "SELECT * FROM brewerymachine;";
    if($this->conn != null) {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return array("error" => "No database connection. Contact network admin.");
    }
  }
}
