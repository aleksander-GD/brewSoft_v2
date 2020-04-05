<?php

require_once '../core/Database.php';
require_once '../models/Productionlist.php';
require 'classes/DatabaseTable.php';

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class ProductionListTest extends TestCase
{

    protected $database;
    protected $handler;

    protected function setUp(): void
    {
        $productionListClass = new ProductionList();
    }


    protected function tearDown(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function getConnection()
    {
        $servername = 'localhost';
        $port = '5432';
        $username = 'postgres';
        $password = 'admin';
        $dbname = 'brewSoftDBTest';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        global $pdo;
        $pdo = new PDO('pgsql:host=' . $servername . ';port=' . $port, $username, $password, $options);
        return $this->createDefaultDBConnection($pdo, $dbname);
    }

   /*  public function test_insert_batch_invalidData()
    {
    } */

    public function test_insert_batch_correctData()
    {
        $validData = [
            'batchid' => '1',
            'productid' => '1',
            'productamount' => '10000',
            'deadline' => '2020-04-05',
            'speed' => '100',
            'status' => 'Completed',
            'dateofcreation' => '2020-04-05',
        ];

        $table = 'productionList';

        $stmt = $this->createMock('PDOStatement');
        $stmt->expects($this->once())
            ->method('execute')
            ->with($validData)
            ->willReturn(true);

        global $pdo;
        $pdo = $this->createMock('PDO');
        $pdo->expects($this->once())
            ->method('prepare')
            ->with("INSERT INTO $table (batchid, productid, productamount, deadline, speed, status, dateofcreation) VALUES (:batchid, :productid, :productamount, :deadline, :speed, :status, :dateofcreation);")
            ->willReturn($stmt);

        $users = new DatabaseTable($table);
        $users->insert($validData);
    }
}
