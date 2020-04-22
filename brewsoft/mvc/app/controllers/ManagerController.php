<?php

//require_once '..\core\Database.php';
//require_once '..\services\BatchService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/BatchService.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/TimeInStateService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/ProductionInfoService.php';

class ManagerController extends Controller
{
	private $BatchService;
	protected $timeInStateService;
	protected $productionInfoService;

	public function __construct(){
		$this->BatchService = new BatchService();
		$this->timeInStateService = new TimeInStateService();
		$this->productionInfoService = new ProductionInfoService;
	}

	

	public function index($param)
	{
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

    public function completedBatches()
    {
        $batches = $this->model('Finalbatchinformation')->getCompletedBatches();
		$viewbag['batches'] = $batches;
		$this->view('manager/completedbatches', $viewbag);
        

    }
	public function planBatch(){
		$product = $this->model('Productionlist')->getProducts();
		$viewbag['products'] = $product;
		$this->view('manager/planbatch', $viewbag);
		
		if (isset($_POST['planbatch'])){
			$batchID = $this->BatchService->createBatchNumber($this->BatchService->getlatestBatchNumber());
			$productID = filter_input(INPUT_POST, "products", FILTER_SANITIZE_STRING);
			$productAmount = filter_input(INPUT_POST, "productAmount", FILTER_SANITIZE_STRING);
			$deadline = strval(filter_input(INPUT_POST, "deadline", FILTER_SANITIZE_STRING));
			$speed = filter_input(INPUT_POST, "speed", FILTER_SANITIZE_STRING);
			$status = 'queued';
			$this->model('Productionlist')->insertBatchToQueue($batchID, $productID, $productAmount, $deadline, $speed, $status);
			header('Location: /brewsoft/mvc/public/manager/batchqueue'); 
		}
	}

	public function batchReport($productionlistID)
	{
		$timeArray = $this->model('TimeInState')->getTimeInStates($productionlistID);
		$length = sizeof($timeArray) - 1;

		$nextBatcTimeInStateID = $timeArray[$length]['timeinstateid'] + 1;
		$nextBatchFirstTime = $this->model('TimeInState')->getFirstTimeNextBatch($nextBatcTimeInStateID);

		$timestampArray = $this->timeInStateService->getTimestampArray($timeArray, $nextBatchFirstTime);
		$allTimesInStateList = $this->timeInStateService->getTimeDifference($timestampArray);
		$sorted = $this->timeInStateService->getSortedTimeInStates($allTimesInStateList);

		$completionDate = $this->model('Finalbatchinformation')->getDateOfCompletion($productionlistID);
		$dateTimeArray = $this->timeInStateService->getDateTimeArray($timeArray, $completionDate);

		$tempAndHumidity = $this->model('Productioninfo')->getTempAndHumid($productionlistID);

		$products = $this->model('Finalbatchinformation')->getProductCounts($productionlistID);

		print_r($tempAndHumidity);
		$viewbag['highlowtemphumid'] = $this->productionInfoService->getHighLowValues($tempAndHumidity);




		$viewbag['tempandhumid'] = $tempAndHumidity;
		$viewbag['datetime'] = $dateTimeArray;
		$viewbag['products'] = $products;
		$this->view('manager/batchreport', $viewbag);



	}
}