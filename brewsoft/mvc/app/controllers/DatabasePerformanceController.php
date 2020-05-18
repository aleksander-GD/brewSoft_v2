<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/Connectiontest.php';
class DatabasePerformanceController extends Controller
{

    protected $connTest;
    public function __construct()
    {
        $this->connTest = new Connectiontest();
    
    }

    public function testDatabaseConnections($connections)
    {
        $this->connTest->testOpenConnectionAmount($connections);
    }


}
