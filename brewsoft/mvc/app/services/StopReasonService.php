<?php 

class StopReasonService
{

    public function getStopReason($reasonArray,$stopID){
        $stopReasonID = 'stopreasonid';
        $reason = 'reason';
        $key = array_search($stopID, array_column($reasonArray, $stopReasonID));
        return $reasonArray[$key][$reason];
    }

}

?>