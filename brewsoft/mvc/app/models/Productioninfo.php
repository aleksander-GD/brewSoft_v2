<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Productioninfo extends Database
{
    public function getTempAndHumid($productionlistID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT temperature, humidity 
                FROM productioninfo
                WHERE productionlistid = :productionlistID 
                ORDER BY productioninfoid ASC;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistID', $productionlistID);
                $stmt->execute();
                $results = $stmt->fetchall();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }
    public function getHighestTemp($productionlistID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT temperature
                FROM productioninfo
                WHERE productionlistid = :productionlistID
                ORDER BY temperature DESC limit 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistID', $productionlistID);
                $stmt->execute();
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getLowestTemp($productionlistID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT temperature
                FROM productioninfo
                WHERE productionlistid = :productionlistID
                ORDER BY temperature ASC limit 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistID', $productionlistID);
                $stmt->execute();
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getHighestHumid($productionlistID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT humidity
                FROM productioninfo
                WHERE productionlistid = :productionlistID
                ORDER BY humidity DESC limit 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistID', $productionlistID);
                $stmt->execute();
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getLowestHumid($productionlistID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT humidity
                FROM productioninfo
                WHERE productionlistid = :productionlistID
                ORDER BY humidity ASC limit 1;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistID', $productionlistID);
                $stmt->execute();
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getHighLowValues($productionlistID)
    {
        $maxtemp = $this->getHighestTemp($productionlistID);
        $mintemp = $this->getlowestTemp($productionlistID);
        $maxhumid = $this->getHighestHumid($productionlistID);
        $minhumid = $this->getlowestHumid($productionlistID);

        if (!empty($maxtemp) && !empty($mintemp) && !empty($maxhumid) && !empty($minhumid)) {
            $highLowTempArray = ['maxtemp' => $maxtemp[0]['temperature'], 'maxhumid' => $maxhumid[0]['humidity'], 'mintemp' => $mintemp[0]['temperature'], 'minhumid' => $minhumid[0]['humidity']];
            return $highLowTempArray;
        } else {
            $highLowTempArray = ['maxtemp' => 0, 'maxhumid' => 0, 'mintemp' => 0, 'minhumid' => 0];
        }
    }
}
