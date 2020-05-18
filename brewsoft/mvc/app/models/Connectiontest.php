<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/ConnectionTestDatabase.php';

class Connectiontest
{
    public function testOpenConnectionAmount($desiredAmount)
    {
        $connArray = array();
        $connectionString = "Connection #";
        for ($i = 0; $i <= $desiredAmount; $i++) {
            $connection = new ConnectionTestDatabase();
            $sql = "INSERT INTO connectiontest (connectionstring) VALUES (:connectionstring);";
            $stmt = $connection->conn->prepare($sql);
            $string = $connectionString . $i;
            $stmt->bindParam(':connectionstring', $string);
            $stmt->execute();
            array_push($connArray, $connection);
            echo $connectionString . $i . " opened";
        }
        $count = 0;
        foreach ($connArray as $key => $value) {
            $data[$key]['conn'] = null;
            echo " Closed " . $count . " connections ";
            $count++;
        }
    }
}
