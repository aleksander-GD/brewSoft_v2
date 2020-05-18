<?php
require_once '../models/Productionlist.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchParameter = filter_input(INPUT_GET, 'searchParameter', FILTER_SANITIZE_STRING);

$model = new Productionlist();
$batchQueueResults = $model->getQueuedBatches();

$batchQueueData = array();

if ($searchParameter !== "" || !empty($searchParameter)) {
    $searchParameter = strtolower($searchParameter);
    $searchParameterLength = strlen($searchParameter);
    foreach ($batchQueueResults as $batch) {
        if (stristr($searchParameter, substr($batch['batchid'], 0, $searchParameterLength))) {
            array_push($batchQueueData, $batch);
        }
        if (stristr($searchParameter, substr($batch['deadline'], 0, $searchParameterLength))) {
            array_push($batchQueueData, $batch);
        }
    }
} else {
    // get all batches if nothing is searched
    $batchQueueData = $batchQueueResults;
}

$batchQueueResults = $batchQueueData;
if (!$batchQueueResults) {
    echo 'Nothing found, no connection to the database';
    echo '<tr>';
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

    foreach ($batchQueueResults as $batch) {

        echo '<tr>';
        echo "<td>" . $batch['productionlistid'] . "</td>";
        echo "<td>" . $batch['batchid'] . "</td>";
        echo "<td>" . $batch['productid'] . "</td>";
        echo "<td>" . $batch['productamount'] . "</td>";
        echo "<td>" . $batch['deadline'] . "</td>";
        echo "<td>" . $batch['speed'] . "</td>";
        echo "<td>" . $batch['status'] . "</td>";
        echo "<td>" . $batch['dateofcreation'] . "</td>";
        echo '</tr>';
    }
}
