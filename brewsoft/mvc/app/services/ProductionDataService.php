<?php
  require_once '../models/ProductionData.php';

  if (session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  
  class ProductionDataService()
  {
    private $barley;
    private $hops;
    
    public function __construct($productionListID)
    {
      $productionListID = filter_input(INPUT_GET, 'productionListID', FILTER_SANITIZE_NUMBER_INT);
  
      $getData = new ProductionData();
      $dataResults = $getData->getProductionData($productionListID);
      
      $data = arrry();
      
      $data = $dataResults;
      
      foreach ($data as $dataset) {
        $barley = $dataset['humidity'];
        $hops = $dataset['temperature'];
      }
    }
    
    public function getBarley($productionListID) {
      $this($productionListID);
      return $barley;
    }
    
    public function getHops($productionListID) {
      $this($productionListID);
      return $hops;
    }
  }
  
?>