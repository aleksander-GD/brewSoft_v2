<?php

//require_once '..\core\Database.php';
//require_once '..\services\BatchService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/BatchService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/OeeService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/TimeInStateService.php';


class ManagerController extends Controller
{
	private $batchService;
	private $oeeService;
	protected $timeInStateService;
	protected $productionInfoService;

	public function __construct()
	{
		$this->batchService = new BatchService();
		$this->oeeService = new OeeService();
		$this->timeInStateService = new TimeInStateService();
	}

	public function index()
	{
		$this->planBatch();
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
		$product = $this->model('ProductType')->getProducts();
		$viewbag['products'] = $product;
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
			header('Location: /brewsoft/mvc/public/manager/batchQueue');
		}
	}


	public function completedBatches()
	{

		$batches = $this->model('Finalbatchinformation')->getCompletedBatches();
		$viewbag['batches'] = $batches;
		$this->view('manager/completedbatches', $viewbag);
	}
	public function planBatch()
	{
		ob_start();
		$product = $this->model('ProductType')->getProducts();
		$viewbag['products'] = $product;
		$this->view('manager/planbatch', $viewbag);

		if (isset($_POST['planbatch'])) {
			$latestBatchNumber = $this->model('productionlist')->getLatestBatchNumber();
			$batchID = $this->batchService->createBatchNumber($latestBatchNumber);
			$productID = filter_input(INPUT_POST, "products", FILTER_SANITIZE_STRING);
			$productAmount = filter_input(INPUT_POST, "productAmount", FILTER_SANITIZE_STRING);
			$deadline = strval(filter_input(INPUT_POST, "deadline", FILTER_SANITIZE_STRING));
			$speed = filter_input(INPUT_POST, "speed", FILTER_SANITIZE_STRING);
			$status = 'queued';
			$this->model('Productionlist')->insertBatchToQueue($productID, $productAmount, $deadline, $speed, $status);
			header('Location: /brewsoft/mvc/public/manager/batchQueue');
		}
	}


	public function batchReport($productionlistID)
	{
		// Start performance requirement 03
		$start_time = microtime(true);
		$viewbag['start'] = $start_time;
		// End of performance requirement 03

		$timeArray = $this->model('TimeInState')->getTimeInStates($productionlistID);
		$length = sizeof($timeArray) - 1;

		$nextBatcTimeInStateID = $timeArray[$length]['timeinstateid'] + 1;
		$nextBatchFirstTime = $this->model('TimeInState')->getFirstTimeNextBatch($nextBatcTimeInStateID);

		$timestampArray = $this->timeInStateService->getTimestampArray($timeArray, $nextBatchFirstTime);
		$allTimesInStateList = $this->timeInStateService->getTimeDifference($timestampArray);
		$sortedTimeInStateList = $this->timeInStateService->getSortedTimeInStates($allTimesInStateList);

		$completionDate = $this->model('Finalbatchinformation')->getDateOfCompletion($productionlistID);
		$dateTimeArray = $this->timeInStateService->getDateTimeArray($timeArray, $completionDate);

		$tempAndHumidity = $this->model('Productioninfo')->getTempAndHumid($productionlistID);

		$products = $this->model('Finalbatchinformation')->getProductCounts($productionlistID);

		//$viewbag['highlowtemphumid'] = $this->productionInfoService->getHighLowValues($tempAndHumidity);
		$viewbag['highlowtemphumid'] = $this->model('Productioninfo')->getHighLowValues($productionlistID);

		$batchResults = $this->model('Finalbatchinformation')->getAcceptedAndTotalCountForProdlistID($productionlistID);
		$idealcycletime = $this->model('ProductType')->getIdealCycleTimeForProductID($batchResults[0]['productid'])[0]['idealcycletime'];

		$availability = $this->oeeService->calculateAvailability($batchResults, $sortedTimeInStateList, $idealcycletime);
		$performance = $this->oeeService->calculatePerformance($batchResults, $sortedTimeInStateList,  $idealcycletime);
		$quality = $this->oeeService->calculateQuality($batchResults);

		$oee = $this->oeeService->calculateOeeForABatch($availability, $performance, $quality);
		$viewbag['availability'] = $availability;
		$viewbag['performance'] = $performance;
		$viewbag['quality'] = $quality;
		$viewbag['oeeForBatch'] = $oee;

		$viewbag['sortedTimes'] = $sortedTimeInStateList;
		$viewbag['datetime'] = $dateTimeArray;
		$viewbag['products'] = $products;
		$viewbag['tempandhumid'] = $tempAndHumidity;
		$this->view('manager/batchreport', $viewbag);
	}

	public function displayOeeForDay()
	{
		if ($this->post()) {

			if (isset($_POST['showOee'])) {
				$batchResults = $this->model('Finalbatchinformation')->getAcceptedAndTotalCountForDate($this->oeeService->getDateOfCompletion());
				$productid = 0;
				foreach ($batchResults as $batchData) {
					$productid = $batchData['productid'];
				}

				$idealCycleTime = $this->model('ProductType')->getIdealCycleTimeForProductID($productid);
				$viewbag['oeeResult'] = $this->oeeService->calculateOeeForOneDay($batchResults, $idealCycleTime);
				//print_r($viewbag);

				$this->view('manager/oee', $viewbag);
			}
		} else {
			$this->view('manager/oee');
		}
	}

	public function displayOeeForBatch($productionListid)
	{
		$timeArray = $this->model('TimeInState')->getTimeInStates($productionListid);

		$completedDate = $this->model('Finalbatchinformation')->getDateOfCompletion($productionListid);

		$dateTimeArray = $this->timeInStateService->getDateTimeArray($timeArray, $completedDate);

		$timeDifference = $this->timeInStateService->getTimeDifference($dateTimeArray);
		$sortedTimes = $this->timeInStateService->getSortedTimeInStates($timeDifference);

		$batchResults = $this->model('Finalbatchinformation')->getAcceptedAndTotalCountForProdlistID($productionListid);
		$idealcycletime = $this->model('ProductType')->getIdealCycleTimeForProductID($batchResults[0]['productid'])[0]['idealcycletime'];

		$availability = $this->oeeService->calculateAvailability($batchResults, $sortedTimes, $idealcycletime);
		$performance = $this->oeeService->calculatePerformance($batchResults, $sortedTimes,  $idealcycletime);
		$quality = $this->oeeService->calculateQuality($batchResults);

		$oee = $this->oeeService->calculateOeeForABatch($availability, $performance, $quality);
		$viewbag['availability'] = $availability;
		$viewbag['performance'] = $performance;
		$viewbag['quality'] = $quality;

		$viewbag['oeeForBatch'] = $oee;
		$this->view('manager/showOeeForBatch', $viewbag);
	}
	public function managerdashboard()
	{
		$this->view('manager/managerdashboard');
	}
	public function logout()
	{
		session_destroy();
		ob_flush();
		header('Location: /brewSoft/mvc/public/home/login');
	}
}
