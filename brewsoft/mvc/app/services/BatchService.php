<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/Productionlist.php';

class BatchService
{
    private $MIN_VALUE = 0;
    private $MAX_VALUE = 65535;
    private $productionlist;

    
    public function __construct()
    {
        $this->productionlist = new Productionlist();
    }

    public function getLatestBatchnumber(){
        $batcNumber = $this->productionlist->getLatestBatchnumber();
        return $batcNumber;
    }

    public function createBatchNumber($latestBatchNumber){
        if(is_null($latestBatchNumber) ){
            return $this->MIN_VALUE;
        }
        elseif($latestBatchNumber >= $this->MIN_VALUE and $latestBatchNumber < $this->MAX_VALUE) {
            $latestBatchNumber += 1;
            return $latestBatchNumber;
        } else {
            return $this->MIN_VALUE;
        }
    }
}
