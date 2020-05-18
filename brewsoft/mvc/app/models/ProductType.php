<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class ProductType extends Database
{
    public function getProducts()
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        }
        $sql = "SELECT productid, productname FROM ProductType";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getIdealCycleTimeForProductID($productid)
    {
        if ($this->check_database_connection() == null || $this->check_database_connection() == false) {
            return false;
            exit();
        }
        $select_query = "SELECT idealcycletime ";
        $from_query = "FROM producttype ";
        $where_query = "WHERE productid = :productid; ";

        $query = $select_query . $from_query . $where_query;

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
    }

    private function check_database_connection()
    {
        return $this->conn != null;
    }
}