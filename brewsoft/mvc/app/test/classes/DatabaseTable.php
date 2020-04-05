<?php
class DatabaseTable
{
    public $table;
    function __construct($table)
    {
        $this->table = $table;
    }
    function insert($record)
    {
        global $pdo;
        $keys = array_keys($record);

        $values = implode(', ', $keys);
        $valuesWithColon = implode(', :', $keys);

        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' .
            $valuesWithColon . ');';

        $stmt = $pdo->prepare($query);

        $stmt->execute($record);
    }
}
