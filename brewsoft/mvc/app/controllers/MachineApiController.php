<?php
/*
 * TODO: Add error handling of cURL results, i.e. startProduction L89
 * TODO: $machineId from somewhere, maybe from the view?
 */
class MachineApiController extends Controller {

  public function index() {
    $this->availableMachines();
  }

  public function availableMachines() {
    $viewbag = [];
    $availMachines = $this->model('MachineList')->getMachineList();
    $viewbag['availableMachines'] = $availMachines;
    $_SESSION["machineMax"] = count($availMachines) - 1;

    //echo "<pre>"; var_dump($viewbag); echo "</pre>";
    // Show the available machines
    $this->view("machine/machines", $viewbag);
  }

  public function chooseMachine() {
    $viewbag = [];
    if($this->post()) {
      try {
        var_dump($_POST);
        $max_range = $_SESSION['machineMax'];//count($this->machineJSON) - 1; // Get from $_POST or other place.
        /*
         DEFAULT VALUE MIGHT CAUSE PROBLEMS!
         DIFFERENT WAY TO VALIDATE?
        */
        //$options = array("options"=>array("default"=>0, "min_range"=>0, "max_range"=>$max_range));
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
        //$_SESSION["machine"][] = $machine;
        $response = json_encode($machine);
        echo "<pre>"; var_dump($response); echo "</pre>";

        $ch = curl_init('http://localhost:8080/chooseMachine');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($response))
        );

        $viewbag["result"] = curl_exec($ch);
        // Close request to clear up some resources
        curl_close($ch);
      } catch (Exception $ex) {
        /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
          $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
      }
    } else {
      $viewbag["error"]['method'] = "Wrong method. Only accessible through POST";
    }

    // Machine chosen, start controlling it
    echo "<pre>"; var_dump($viewbag); echo "</pre>";
    $this->view("machine/machines", $viewbag);
  }

  public function startProduction() {
    $viewbag = [];
    try {
      $ch = curl_init('http://localhost:8080/machineStart?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("machine/controls", $viewbag);
  }

  public function stopProduction() {
    try {
      $ch = curl_init('http://localhost:8080/machineStop?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("machine/controls", $viewbag);
  }

  public function resetMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineReset?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("machine/controls", $viewbag);
  }

  public function clearMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineClear?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("machine/controls", $viewbag);
  }

  public function abortMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineAbort?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("machine/controls", $viewbag);
  }

  public function machineControls() {
    $endpoint = "http://localhost:8080/MachineControls";
    $viewbag = [];

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
            $viewbag["error"]["http_code"] = 'Unexpected HTTP code: '. $http_code. "\n";
            $viewbag["error"]["response"] = $resp;
        }
      }
      // Close request to clear up some resources
      curl_close($curl);
    } catch (Exception $ex) {
      /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      $viewbag["error"]["exception"] = sprintf("Error while sending request, reason: %s\n",$ex->getMessage());

    }
    // Show available commands
    $this->view("machine/controls", $viewbag);
  }
}
