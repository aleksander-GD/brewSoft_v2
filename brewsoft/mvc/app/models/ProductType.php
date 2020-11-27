<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class ProductType extends Database
{
    public function getProducts()
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT productid, productname, speed FROM ProductType";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getIdealCycleTimeForProductID($productid)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $select_query = "SELECT idealcycletime ";
            $from_query = "FROM producttype ";
            $where_query = "WHERE productid = :productid; ";

            $query = $select_query . $from_query . $where_query;
            try {
                $prepared_statement = $this->conn->prepare($query);
                $prepared_statement->bindParam(':productid', intval($productid));
                $prepared_statement->execute();
                $results = $prepared_statement->fetchAll();

                $resultObject = array();
                foreach ($results as $result) {
                    $convertedResults['idealcycletime'] = floatval($result['idealcycletime']);
                    $resultObject[] = $convertedResults;
                }
                return $resultObject;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }
}
