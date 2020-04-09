<?php

//require_once '..\core\Database.php';

class ManagerController extends Controller
{

    public function completedBatches()
    {
        $batches = $this->model('Finalbatchinformation')->getCompletedBatches();
        $viewbag['batches'] = $batches;
        $this->view('manager/completedbatches', $viewbag);

    }
    

}