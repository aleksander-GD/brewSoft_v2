<?php

use PHPUnit\Framework\TestCase;

require_once '../core/Database.php';
require_once '../core/Controller.php';
require_once '../controllers/MachineApiController.php';

class MachineApiControllerTest extends TestCase {

    protected $machine;
    protected $machineArr;

    protected function setUp(): void {
        $this->machine = new MachineApiController;

        $this->machineArr = array (
            0 => array (
                'brewerymachineid' => 1,
                'hostname' => '192.168.0.122',
                'port' => 4840
            ),

            1 => array (
                'brewerymachineid' => 2,
                'hostname' => '127.0.0.1',
                'port' => 4840
            ),

            2 => array (
                'brewerymachineid' => 3,
                'hostname' => '127.0.0.1',
                'port' => 4840
            ),

            3 => array (
                'brewerymachineid' => 4,
                'hostname' => '127.0.0.1',
                'port' => 4840
            )
        );
    }

    public function testFetchingAvailableMachines() {
        $viewbag = [];
        $viewbag['availableMachines'] = $this->machineArr;

        $this->assertEquals($this->machine->availableMachines(), $viewbag);
    }

    public function testArrayHasKeys() {
        $array = $this->machine->availableMachines();
        $key = array('brewerymachineid', 'hostname', 'port');
        foreach($array as $row => $innerArray) {
            foreach ($innerArray as $innerRow => $values) {
                $i = 0;
                foreach ($key as $value) {
                    $this->assertArrayHasKey($key[$i], $values, "Array does not contain key: '$key[$i]'");
                    $i++;
                }
            }
        }
    }
}