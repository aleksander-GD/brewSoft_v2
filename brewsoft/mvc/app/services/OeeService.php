<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/models/Finalbatchinformation.php';
class OeeService
{
    private $dateofcompletion;
    private $finalbatchinformationModel;
    private $plannedProductionTime;

    public function __construct()
    {
        $this->dateofcompletion = filter_input(INPUT_POST, "dateofcompletion", FILTER_SANITIZE_STRING);
        //$this->dateofcompletion = "2019-12-04"; // For test

        $this->finalbatchinformationModel = new Finalbatchinformation();
        $this->plannedProductionTime = 28800;
    }

    public function calculateOeeForOneDay()
    {
        $batchResults = $this->finalbatchinformationModel->getAcceptedCount($this->dateofcompletion);

        $oee = 0;
        foreach ($batchResults as $batchData) {
            if (is_numeric($batchData['acceptedcount']) && is_numeric($batchData['idealcycletime'])) {
                $oee += $batchData['acceptedcount'] + $batchData['idealcycletime'];
            } else {
                // error handling
            }
        }

        $calculateOee = ($oee / $this->plannedProductionTime) * 100;

        return $calculateOee;
    }

    public function calculateAvailability()
    {
    }
    public function calculatePerformance()
    {
    }

    public function calculateQuality()
    {
    }
}
