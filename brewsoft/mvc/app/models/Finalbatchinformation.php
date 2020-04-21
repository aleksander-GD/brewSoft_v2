<?php
//require_once '..\core\Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Finalbatchinformation extends Database
{
    public function getCompletedBatches()
    {
        $sql = "SELECT pl.batchid, fb.* 
                FROM productionlist AS pl, finalbatchinformation as fb
                WHERE pl.productionlistid = fb.productionlistid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }


    public function getAcceptedCount($dateofcompletion)
    {
        $select_query = "SELECT fbi.productid, fbi.acceptedcount, pt.idealcycletime ";
        $from_query = "FROM finalbatchinformation AS fbi, producttype AS pt ";
        $where_query = "WHERE fbi.dateofcompletion = :dateofcompletion AND fbi.productid = pt.productid; ";

        $query = $select_query . $from_query . $where_query;

        $prepared_statement = $this->conn->prepare($query);
        $prepared_statement->bindParam(':dateofcompletion', $dateofcompletion);
        $prepared_statement->execute();
        $results = $prepared_statement->fetchAll();

        $resultObject = array();
        foreach ($results as $result) {
            $convertedResults['productid'] = intval($result['productid']);
            $convertedResults['acceptedcount'] = intval($result['acceptedcount']);
            $convertedResults['idealcycletime'] = intval($result['idealcycletime']);
            $resultObject[] = $convertedResults;
        }

        return $resultObject;
    }

    public function getDateOfCompletion($productionlistID){
        $sql = "SELECT dateofcompletion 
                FROM finalbatchinformation
                WHERE productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }
}
