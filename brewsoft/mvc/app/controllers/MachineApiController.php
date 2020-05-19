<?php
/*
 * TODO: Add error handling of cURL results, i.e. startProduction L89
 * TODO: $machineId from somewhere, maybe from the view?
 */
class MachineApiController extends Controller
{

  public function index()
  {
    $this->machineControls();
    $this->view('brewworker/dashboard');
  }

  protected function validate() {
    $max_range = $_SESSION['machineMax'];
    $filters = array(
      "hostname" => FILTER_SANITIZE_STRING,
      "port" => FILTER_VALIDATE_INT,
      "machineID" => array("filter"=> FILTER_VALIDATE_INT,
                           "options"=> array("default" => 0,
                                             "min_range" => 0,
                                             "max_range" => $max_range
                                            )
                          )
    );
    $machine = filter_input_array(INPUT_POST, $filters);
    return $machine;
  }

  public function availableMachines() {
    $viewbag = [];
    $availMachines = $this->model('MachineList')->getMachineList();
    if (!empty($availMachines["error"])) {
      $viewbag['error']["databaseconnection"] = $availMachines["error"];
      // MANUEL INDTASTNING AF HOSTNAME + PORT?
      // MANUEL INDTASTNING AF BATCH INFORMATION?
    } else {
      $viewbag['availableMachines'] = $availMachines;
      $_SESSION["machineMax"] = count($availMachines);
    }

    return $viewbag;
  }

  public function chooseMachine()
  {
    $viewbag = [];
    if ($this->post()) {
      try {
        $max_range = $_SESSION['machineMax'];
        $filters = array(
          "hostname" => FILTER_SANITIZE_STRING,
          "port" => FILTER_VALIDATE_INT,
          "machineID" => array(
            "filter" => FILTER_VALIDATE_INT,
            "options" => array(
              "default" => 0,
              "min_range" => 0,
              "max_range" => $max_range
            )
          )
        );
        $machine = filter_input_array(INPUT_POST, $filters);
        $response = json_encode($machine);

        $ch = curl_init('http://localhost:8080/chooseMachine');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($response)
          )
        );

        $viewbag["result"] = curl_exec($ch);
        // Close request to clear up some resources
        curl_close($ch);
      } catch (Exception $ex) {
        /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
        $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
      }
    } else {
      $viewbag["error"]['method'] = "Wrong method. Only accessible through POST";
    }

  }

  public function startProduction($machineId)
  {
    $viewbag = [];
    try {
      $machine = $this->validate();
      $ch = curl_init('http://localhost:8080/machineStart?machineId='.$machine['machineID']);
      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));
      $result = json_decode(curl_exec($ch));
      if (isset($result->Error)) {
        $viewbag["error"]["API"] = $result->Error;
      }
      if (isset($result->Success)) {
        $viewbag["success"]["API"] = $result->Success;
      }
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    echo json_encode($viewbag);
  }

  public function stopProduction($machineId)
  {
    $viewbag = [];
    try {
      $machine = $this->validate();
      $ch = curl_init('http://localhost:8080/machineStop?machineId='.$machine['machineID']);
      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));
      $result = json_decode(curl_exec($ch));
      if (isset($result->Error)) {
        $viewbag["error"]["API"] = $result->Error;
      }
      if (isset($result->Success)) {
        $viewbag["success"]["API"] = $result->Success;
      }
      $viewbag["method"] = "stop";
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    echo json_encode($viewbag);
  }

  public function resetMachine($machineId)
  {
    $viewbag = [];
    try {
      $machine = $this->validate();
      $endpoint = 'http://localhost:8080/machineReset?machineId='.$machine["machineID"];
      $ch = curl_init();
      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_URL => $endpoint,
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));

      $result = json_decode(curl_exec($ch));
      if (isset($result->Error)) {
        $viewbag["error"]["API"] = $result->Error;
      }
      if (isset($result->Success)) {
        $viewbag["success"]["API"] = $result->Success;
      }
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    echo json_encode($viewbag);
  }

  public function clearMachine($machineId)
  {
    $viewbag = [];
    try {
      $machine = $this->validate();
      $ch = curl_init('http://localhost:8080/machineClear?machineId='.$machine['machineID']);
      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));
      $result = json_decode(curl_exec($ch));
      if (isset($result->Error)) {
        $viewbag["error"]["API"] = $result->Error;
      }
      if (isset($result->Success)) {
        $viewbag["success"]["API"] = $result->Success;
      }
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    echo json_encode($viewbag);
  }

  public function abortMachine($machineId)
  {
    $viewbag = [];
    try {
      $machine = $this->validate();
      $ch = curl_init('http://localhost:8080/machineAbort?machineId='.$machine['machineID']);
      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));
      $result = json_decode(curl_exec($ch));
      if (isset($result->Error)) {
        $viewbag["error"]["API"] = $result->Error;
      }
      if (isset($result->Success)) {
        $viewbag["success"]["API"] = $result->Success;
      }
      $viewbag["method"] = "abort";
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    echo json_encode($viewbag);
  }

  public function saveStopReason()
  {
    if ($this->post()) {
      echo "POST: <pre>";
      var_dump($_POST);
      echo "</pre>";
      $this->model('manualstopreason')->saveStopReason();
    }
  }

  public function machineControls()
  {
    $viewbag = [];
    if ($this->post()) {
      $max_range = $_SESSION['machineMax'];
      $filters = array(
        "hostname" => FILTER_SANITIZE_STRING,
        "port" => FILTER_VALIDATE_INT,
        "machineID" => array(
          "filter" => FILTER_VALIDATE_INT,
          "options" => array(
            "default" => 0,
            "min_range" => 0,
            "max_range" => $max_range
          )
        ),
        "command" => FILTER_SANITIZE_STRING
      );
      $machine = filter_input_array(INPUT_POST, $filters);

      switch ($machine["command"]) {
        case 'Start':
          $return = $this->startProduction($machine["machineID"]);
          break;
        case 'Stop':
          $return = $this->stopProduction($machine["machineID"]);
          break;
        case 'Reset':
          $return = $this->resetMachine($machine["machineID"]);
          break;
        case 'Clear':
          $return = $this->clearMachine($machine["machineID"]);
          break;
        case 'Abort':
          $return = $this->abortMachine($machine["machineID"]);
          break;
      }

      $viewbag += $return;
      echo "<pre>";
      var_dump($viewbag);
      echo "</pre>";
    }
    $viewbag += $this->availableMachines();
    $endpoint = "http://localhost:8080/MachineControls";

    try {
      // Get cURL resource
      $curl = curl_init();
      // Set some options
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $endpoint,
        CURLOPT_HTTPHEADER => ['Accept:application/json']
      ));
      // Send the request & save response to $resp
      $resp = curl_exec($curl);

      // Check HTTP status code
      if (!curl_errno($curl)) {
        switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
          case 200:  # OK
            $viewbag["controls"] = json_decode($resp);
            break;
          default:
            $viewbag["error"]["http_code"] = 'Unexpected HTTP code: ' . $http_code . "\n";
            $viewbag["error"]["response"] = $resp;
        }
      } else {
        $viewbag["error"]["curl"] = curl_error($curl) . ". Check the machinecontroller is running.";
      }
      // Close request to clear up some resources
      curl_close($curl);
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n", $ex->getMessage());
    }
    // Show available commands
    $this->view("machine/controls", $viewbag);
    $this->view("brewworker/Dashboard");
  }
  public function logout()
	{
		session_destroy();
		header('Location: /brewSoft/mvc/public/home/login');
	}
}
