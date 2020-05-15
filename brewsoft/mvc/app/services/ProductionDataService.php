<?php
  require_once '../models/ProductionData.php';

  class ProductionDataService
  { 

    private $productionlistID = 0;
    private $machineID = 0;

    private $model;

    public function __construct(){
      $this->model = new ProductionData();
    }
    
    public function getIngredients()
    {
      $ingredientsData = $model->ingredientsUpdate($this->machineID);

      $ingredients = array(
        "barley"=>$ingredientsData['barley'],
        "hops"=>$ingredientsData['hops'],
        "malt"=>$ingredientsData['malt'],
        "wheat"=>$ingredientsData['wheat'],
        "yeast"=>$ingredientsData['yeast']
      );

      echo json_encode($ingredients);
    }

    public function getProductionData()
    {
      $startproduction = $modul->StartProduction();

      $this->productionlistID = $startproduction['productionlistid'];
      $this->machineID = $startproduction['machineid'];

      $productionData = array(
        "productType"=>$startproduction['productid'],
        "batchID"=>$startproduction['batchid'],
        "toBeProduced"=>$startproduction['productamount'],
        "productsPerMinut"=>$startproduction['speed']
      );

      echo json_encode($productionData);
    }

    public function getProducedData()
    {
      $getproducedData = $model->ProducedData($this->productionlistID);

      $producedData = array(
        "produced"=>$getproducedData['produced'],
        "acceptableCount"=>$getproducedData['acceptable'],
        "defectCount"=>$getproducedData['defect']
      );

      echo json_encode($producedData);
    }

    public function getMachineData()
    {
      $machineDataRecived = $model->MachineData($this->productionlistID, $this->machineID);
      $stopreason = $model->ProductionStop($this->productionlistID, $this->machineID);

      $machineData = array(
        "temperature"=>$machineDataRecived['temperature'],
        "humidity"=>$machineDataRecived['humidity'],
        "vibration"=>$machineDataRecived['vibration'],
        "stopReason"=>$stopreason['stopreasonid'],
        "maintenance"=>$machineDataRecived['maintenace'],
        "state"=>$machineDataRecived['state']
      );

      echo json_encode($machineData);
    }
  }

  $objInstance = new ProductionDataService();
  $filterInput = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING);

  switch ($filterInput) {
    case 'getIngredients':
      echo $objInstance->getIngredients();
      break;
    case 'getProductionData':
      echo $objInstance->getProductionData();
      break;
    case 'getProducedData':
      echo $objInstance->getProducedData();
      break;
    case 'getMachineData':
      echo $objInstance->getMachineData();
      break;
    default:
      echo "Not a variable";
      break;
  }

?>