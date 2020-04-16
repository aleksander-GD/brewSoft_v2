<?php

//require_once '..\core\Database.php';

class ManagerController extends Controller
{

	public function index($param)
	{
		//TODO


	}

	public function batchQueue()
	{
		/* $batches = $this->model('Productionlist')->getQueuedBatches();
		$viewbag['batches'] = $batches; */

		//Redirect to correct view
		$this->view('manager/batchqueue');
	}

	public function editBatch($id)
	{
		$batch = $this->model('Productionlist')->getQueuedBatchFromListID($id);
		//the selected batch is sent to the view.
		$viewbag['batch'] = $batch;

		//redirect to editbatch page
		$this->view('manager/editbatch', $viewbag);

		//Data that is sent via post from the view, to update the batch
		if (isset($_POST['editbutton'])) {
			$productID = filter_input(INPUT_POST, "productID", FILTER_SANITIZE_STRING);
			$productAmount = filter_input(INPUT_POST, "productAmount", FILTER_SANITIZE_STRING);
			$deadline = filter_input(INPUT_POST, "deadline", FILTER_SANITIZE_STRING);
			$speed = filter_input(INPUT_POST, "speed", FILTER_SANITIZE_STRING);

			$this->model('Productionlist')->editQueuedBatch($productID, $productAmount, $deadline, $speed, $id);

			//redirect to batchqueue 
			//$this->view('manager/batchqueue');
			header('Location: /brewsoft/mvc/public/manager/batchqueue');
		}
	}

	public function batchReport($productionlistID){
		$timeArray = $this->model('TimeInState')->getTimeInStates($productionlistID);
		$length = sizeof($timeArray) - 1; 
		$nextBatcTimeInStateID = $timeArray[$length]['timeinstateid'] + 1 ;

		$nextBatchFirstTime = $this->model('TimeInState')->getFirstTimeNextBatch($nextBatcTimeInStateID);
		print_r($times);
		echo sizeof($times);
		$strStart = $times[0]['starttimeinstate'];
		$strEnd = $times[1]['starttimeinstate'];
		$dteStart = new DateTime($strStart);
		$dteEnd   = new DateTime($strEnd);
		$dteDiff  = $dteStart->diff($dteEnd);
		print $dteDiff->format("%H:%I:%S");
		
	}
}
