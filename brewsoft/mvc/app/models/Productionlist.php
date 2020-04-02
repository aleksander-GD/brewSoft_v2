<?php 

require_once '..\core\Database.php';

class Productionlist extends Database{

    public function getLatestBatchNumber(){
		$sql = "SELECT * FROM productionlist ORDER BY productionlistID DESC limit 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result["batchid"];
    }

}