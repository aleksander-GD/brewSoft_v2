<?php

use PHPUnit\Framework\TestCase;

//$doc_root = implode("/",array_slice(explode("/", $_SERVER['REQUEST_URI']),0,3));
//require_once $doc_root.'/app/core/Database.php';
require_once '../core/Database.php';
require_once '../core/Controller.php';
require_once '../models/MachineList.php';
require_once '../controllers/MachineApiController.php';

class MachineApiControllerTest extends TestCase {

    protected $machine;
    protected $machineArr;

    protected function setUp(): void {
        $this->machine = new MachineApiController;

        $this->machineArr = array (
            0 => array (
                'brewerymachineid' => 1,
                'hostname' => '127.0.0.1',
                'port' => 4321
            )
        );
    }

    public function testFetchingAvailableMachines() {
        $viewbag = [];
        $viewbag['availableMachines'] = $this->machineArr;

        $this->assertEquals($this->machine->availableMachines(), $viewbag);
    }
}