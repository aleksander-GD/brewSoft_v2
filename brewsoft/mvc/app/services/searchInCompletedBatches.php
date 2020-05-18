<?php
require_once '../models/Finalbatchinformation.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchParameter = filter_input(INPUT_GET, 'searchParameter', FILTER_SANITIZE_STRING);

$model = new Finalbatchinformation();
$completedBatchResults = $model->getCompletedBatches();

$completedBatchData = array();

if ($searchParameter !== "" || !empty($searchParameter)) {
    $searchParameter = strtolower($searchParameter);
    $searchParameterLength = strlen($searchParameter);
    foreach ($completedBatchResults as $batch) {
        if (stristr($searchParameter, substr($batch['batchid'], 0, $searchParameterLength))) {
            array_push($completedBatchData, $batch);
        }
        if (stristr($searchParameter, substr($batch['dateofcompletion'], 0, $searchParameterLength))) {
            array_push($completedBatchData, $batch);
        }
    }
} else {
    // get all batches if nothing is searched
    $completedBatchData = $completedBatchResults;
}

$completedBatchResults = $completedBatchData;
if (!$completedBatchResults) {
    echo 'Nothing found, no connection to the database';
    echo '<tr>';
    echo "<td>" . "</td>";
    echo "<td>" . "</td>";
    echo "<td>" . "</td>";
    echo "<td>" . "</td>";
    echo "<td>"  . "</td>";
    echo "<td>"  . "</td>";
    echo "<td>"  . "</td>";
    echo "<td>"  . "</td>";
    echo "<td>"  . "</td>";
    echo "<td>"  . "</td>";
    echo '</tr>';
} else {
    foreach ($completedBatchResults as $batch) {

        echo '<tr>';
        echo "<td>" . $batch['productionlistid'] . "</td>";
        echo "<td>" . $batch['batchid'] . "</td>";
        echo "<td>" . $batch['brewerymachineid'] . "</td>";
        echo "<td>" . $batch['deadline'] . "</td>";
        echo "<td>" . $batch['dateofcreation'] . "</td>";
        echo "<td>" . $batch['dateofcompletion'] . "</td>";
        echo "<td>" . $batch['productid'] . "</td>";
        echo "<td>" . $batch['totalcount'] . "</td>";
        echo "<td>" . $batch['defectcount'] . "</td>";
        echo "<td>" . $batch['acceptedcount'] . "</td>";
        echo '</tr>';
    }
}
