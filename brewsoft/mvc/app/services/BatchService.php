<?php

class BatchService
{
    private const MIN_VALUE = 0;
    private const MAX_VALUE = 65535;


    public function getLatestBatchnumber(){

    }
    
    public function incrementBatchNumber($latestBatchNumber){
        if($latestBatchNumber == null){
            return $this->MIN_VALUE;
        } elseif($latestBatchNumber >= $this->MIN_VALUE && $latestBatchNumber < $this->MAX_VALUE) {
            return $latestBatchNumber += 1;
        } else {
            return $this->MIN_VALUE;
        }
    }

    public function createBatchNumber(){

    }


}
