<?php
  $endpoint = "http://localhost:8080/ChooseMachine";
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
                echo "Server JSON Response:" . $resp;
                $json = json_decode($resp);
                echo "<pre>";var_dump($json);echo "</pre>";
                $response = json_encode($json[1]);
                echo "<pre>";var_dump($response);echo "</pre>";

                $ch = curl_init('http://localhost:8080/MachineChoice');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($response))
                );

                $result = curl_exec($ch);

                echo "<pre>";var_dump($result);echo "</pre>";

                break;
            default:
                echo 'Unexpected HTTP code: ', $http_code, "\n";
                echo $resp;
        }
    }
    // Close request to clear up some resources
    curl_close($curl);
  } catch (Exception $ex) {

      printf("Error while sending request, reason: %s\n",$ex->getMessage());

  }
