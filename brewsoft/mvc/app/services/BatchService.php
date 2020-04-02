<?php


class BatchService
{
    private $MIN_VALUE = 0;
    private $MAX_VALUE = 65535;


    public function getLatestBatchnumber(){
        
    }

    public function incrementBatchNumber($latestBatchNumber){
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

    public function createBatchNumber(){
        
    }


}
