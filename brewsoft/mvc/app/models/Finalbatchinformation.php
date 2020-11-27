<?php
//require_once '..\core\Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';

class Finalbatchinformation extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCompletedBatches()
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT pl.batchid, fb.productionlistid, fb.brewerymachineid, fb.deadline, 
        fb.dateofcreation, fb.dateofcompletion, fb.productid, fb.totalcount, fb.defectcount, fb.acceptedcount 
                FROM productionlist AS pl, finalbatchinformation as fb
                WHERE pl.productionlistid = fb.productionlistid;";
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

    public function getAcceptedAndTotalCountForDate($dateofcompletion)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $select_query = "SELECT fbi.productid, fbi.acceptedcount, fbi.totalcount ";
            $from_query = "FROM finalbatchinformation AS fbi ";
            $where_query = "WHERE fbi.dateofcompletion = :dateofcompletion ";

            $query = $select_query . $from_query . $where_query;
            try {
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
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getAcceptedAndTotalCountForProdlistID($productionlistid)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $select_query = "SELECT fbi.productid, fbi.acceptedcount, fbi.totalcount ";
            $from_query = "FROM finalbatchinformation AS fbi ";
            $where_query = "WHERE fbi.productionlistid = :productionlistid ";

            $query = $select_query . $from_query . $where_query;
            try {
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
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getDateOfCompletion($productionListID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT dateofcompletion 
                FROM finalbatchinformation
                WHERE productionlistid = :productionlistid;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":productionlistid", $productionListID);
                $stmt->execute([$productionListID]);
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getProductCounts($productionListID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT pt.productname, fb.totalcount, fb.defectcount, fb.acceptedcount 
        FROM producttype AS pt, finalbatchinformation as fb
        WHERE pt.productid = fb.productid AND productionlistid = :productionlistid;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":productionlistid", $productionListID);
                $stmt->execute([$productionListID]);
                $results = $stmt->fetch();
                return $results;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function getAllStaticDataFromProdlistID($productionListID)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT fb.*, pl.batchid, pl.speed, pt.productname 
        FROM finalbatchinformation AS fb, productionlist AS pl, producttype AS pt
        WHERE fb.productid = pt.productid AND fb.productionlistid = pl.productionlistid AND fb.productionlistid = :productionlistid;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':productionlistid', $productionListID);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }
}
