<?php
//require_once '..\core\Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Finalbatchinformation extends Database
{
    public function getCompletedBatches()
    {
        $sql = "SELECT pl.batchid, fb.productionlistid, fb.brewerymachineid, fb.deadline, 
        fb.dateofcreation, fb.dateofcompletion, fb.productid, fb.totalcount, fb.defectcount, fb.acceptedcount 
                FROM productionlist AS pl, finalbatchinformation as fb
                WHERE pl.productionlistid = fb.productionlistid;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * 
     */
    public function getAcceptedAndTotalCountForDate($dateofcompletion)
    {
        $select_query = "SELECT fbi.productid, fbi.acceptedcount, fbi.totalcount, pt.idealcycletime ";
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
            $convertedResults['totalcount'] = intval($result['totalcount']);
            $resultObject[] = $convertedResults;
        }

        return $resultObject;
    }

    public function getAcceptedAndTotalCountForProdlistID($productionlistid)
    {
        $select_query = "SELECT fbi.productid, fbi.acceptedcount, fbi.totalcount ";
        $from_query = "FROM finalbatchinformation AS fbi, producttype AS pt ";
        $where_query = "WHERE fbi.productionlistid = :productionlistid AND fbi.productid = pt.productid; ";

        $query = $select_query . $from_query . $where_query;

        $prepared_statement = $this->conn->prepare($query);
        $prepared_statement->bindParam(':productionlistid', $productionlistid);
        $prepared_statement->execute();
        $results = $prepared_statement->fetchAll();

        $resultObject = array();
        foreach ($results as $result) {
            $convertedResults['productid'] = intval($result['productid']);
            $convertedResults['acceptedcount'] = intval($result['acceptedcount']);
            $convertedResults['totalcount'] = intval($result['totalcount']);
            $resultObject[] = $convertedResults;
        }

        return $resultObject;
    }

    public function getIdealCycleTimeForProdID()
    {
        $select_query = "SELECT fbi.productid, fbi.acceptedcount, fbi.totalcount, pt.idealcycletime";
        $from_query = "FROM finalbatchinformation AS fbi, producttype AS pt ";
        $where_query = "WHERE fbi.productionlistid = :productionlistid AND fbi.productid = pt.productid; ";

        $query = $select_query . $from_query . $where_query;

        $prepared_statement = $this->conn->prepare($query);
        $prepared_statement->bindParam(':productionlistid', $productionlistid);
        $prepared_statement->execute();
        $results = $prepared_statement->fetchAll();

        $resultObject = array();
        foreach ($results as $result) {
            $convertedResults['idealcycletime'] = floatval($result['idealcycletime']);
            $resultObject[] = $convertedResults;
        }

        return $resultObject;
    }


    public function getDateOfCompletion($productionlistID)
    {
        $sql = "SELECT dateofcompletion 
                FROM finalbatchinformation
                WHERE productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }

    public function getProductCounts($productionlistID)
    {
        $sql = "SELECT pt.productname, fb.totalcount, fb.defectcount, fb.acceptedcount 
        FROM producttype AS pt, finalbatchinformation as fb
        WHERE pt.productid = fb.productid AND productionlistid =" . $productionlistID . ";";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }
}
