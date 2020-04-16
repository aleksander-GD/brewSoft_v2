<?php
/*
 * TODO: Add error handling of cURL results
 */
class MachineApiController extends Controller {
  private $machineJSON;
  private $machineId;

  public function availableMachines() {
    $endpoint = "http://localhost:8080/availableMachines";
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
                  $this->machineJSON = json_decode($resp);
                  $viewbag["json"] = $this->machineJSON;
                  break;
              default:
              /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
                  $viewbag["error"]["http_code"] = 'Unexpected HTTP code: ', $http_code, "\n";
                  $viewbag["error"]["response"] = $resp;
          }
      }
      // Close request to clear up some resources
      curl_close($curl);
    } catch (Exception $ex) {
/* LOG ERROR, SEND TO ALARM VIEW THINGIE */
        printf("Error while sending request, reason: %s\n",$ex->getMessage());

    }
    // Show the available machines
    $this->view("", $viewbag);
  }

  public function chooseMachine() {
    try {
      $max_range = count($machineJSON) - 1;
      /*
       DEFAULT VALUE MIGHT CAUSE PROBLEMS!
       DIFFERENT WAY TO VALIDATE?
      */
      $options = array("options"=>array("default"=>0, "min_range"=>0, "max_range"=>$max_range);
      $machine = filter_input(INPUT_POST, "", FILTER_VALIDATE_INT, $options);
      $machineId = $machineJSON[$machine]->machineID;
      $response = json_encode($machineJSON[$machine]);

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
        printf("Error while sending request, reason: %s\n",$ex->getMessage());

    }
    // Machine chosen, start controlling it
    $this->view("", $viewbag);
  }

  public function startProduction() {
    try {
      $ch = curl_init('http://localhost:8080/machineStart?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
  /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      printf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("", $viewbag);
  }

  public function stopProduction() {
    try {
      $ch = curl_init('http://localhost:8080/machineStop?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      printf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("", $viewbag);
  }

  public function resetMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineReset?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      printf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("", $viewbag);
  }

  public function clearMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineClear?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      printf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("", $viewbag);
  }

  public function abortMachine() {
    try {
      $ch = curl_init('http://localhost:8080/machineAbort?machineId='.$machineId);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $viewbag["result"] = curl_exec($ch);
    } catch (Exception $ex) {
    /* LOG ERROR, SEND TO ALARM VIEW THINGIE */
      printf("Error while sending request, reason: %s\n",$ex->getMessage());
    }
    // new view?
    $this->view("", $viewbag);
  }

  public function machineControls() {
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
                  $viewbag["json"] = json_decode($resp);
                  break;
              default:
                  $viewbag["error"]["http_code"] = 'Unexpected HTTP code: ', $http_code, "\n";
                  $viewbag["error"]["response"] = $resp;
          }
      }
      // Close request to clear up some resources
      curl_close($curl);
    } catch (Exception $ex) {
/* LOG ERROR, SEND TO ALARM VIEW THINGIE */
        printf("Error while sending request, reason: %s\n",$ex->getMessage());

    }
    // Show available commands
    $this->view("", $viewbag);
  }
}
