<?php
class MachineList extends Database {

  public function getMachineList() {
      if ($this->getConnection() == null) {
          return array("error" => "No database connection. Contact network admin.");
          exit();
      } else {
          $sql = "SELECT * FROM brewerymachine ORDER BY brewerymachineid ASC;";
          try {
              $stmt = $this->conn->prepare($sql);
              $stmt->execute();
              return $stmt->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {
              return false;
              exit();
          }
      }
  }
}
