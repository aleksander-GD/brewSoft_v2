<?php
  require_once '../models/ProductionData.php';

  $productionlistID = 0;

  class ProductionDataService
  { 
    public function __construct(){
    }
    
    public function getIngredients() {
      $ingredients = array(
        "barley"=>100,
        "hops"=>100,
        "malt"=>100,
        "wheat"=>100,
        "yeast"=>100
      );

      echo json_encode($ingredients);
    }

    public function getProductionData()
    {
      $model = new ProductionData();
      $startproduction = $modul->StartProduction();

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
      $producedData = array(
        "produced"=>500,
        "acceptableCount"=>400,
        "defectCount"=>100
      );

      echo json_encode($producedData);
    }

    public function getMachineData()
    {
      $model = new ProductionData();
      $machineDataRecived = $model->MachineData(1);

      $machineData = array(
        "temperature"=>$machineDataRecived['temperature'],
        "humidity"=>$machineDataRecived['humidity'],
        "vibration"=>100,
        "stopReason"=>1,
        "maintenance"=>50,
        "state"=>1
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