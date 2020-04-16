<?php

//require_once '..\core\Database.php';
//require_once '..\services\BatchService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/BatchService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/services/OeeService.php';

class ManagerController extends Controller
{
	private $batchService;
	private $oeeService;

	public function __construct()
	{
		$this->batchService = new BatchService();
		$this->oeeService = new OeeService();
	}


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

	public function completedBatches()
	{
		$batches = $this->model('Finalbatchinformation')->getCompletedBatches();
		$viewbag['batches'] = $batches;
		$this->view('manager/completedbatches', $viewbag);
	}
	public function planBatch()
	{
		$product = $this->model('Productionlist')->getProducts();
		$viewbag['products'] = $product;
		$this->view('manager/planbatch', $viewbag);

		if (isset($_POST['planbatch'])) {
			$batchID = $this->batchService->createBatchNumber($this->BatchService->getlatestBatchNumber());
			$productID = filter_input(INPUT_POST, "products", FILTER_SANITIZE_STRING);
			$productAmount = filter_input(INPUT_POST, "productAmount", FILTER_SANITIZE_STRING);
			$deadline = strval(filter_input(INPUT_POST, "deadline", FILTER_SANITIZE_STRING));
			$speed = filter_input(INPUT_POST, "speed", FILTER_SANITIZE_STRING);
			$status = 'queued';
			$this->model('Productionlist')->insertBatchToQueue($batchID, $productID, $productAmount, $deadline, $speed, $status);
			header('Location: /brewsoft/mvc/public/manager/batchqueue');
		}
	}

	public function displayOeeForDay()
	{

		$this->view('manager/oee');


		if ($this->post()) {

			if (isset($_POST['showOee'])) {

				$viewbag['oeeResult'] = round($this->oeeService->calculateOeeForOneDay(), 2);
				$this->view('manager/oee', $viewbag);
			}
		}
	}

	public function displayOeeForBatch()
	{

		//$this->view('manager/');
	}
}
