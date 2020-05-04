<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/brewsoft/mvc/app/core/Database.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$response = "";
if ($database->conn != null) {

    $response = json_encode(true);
    echo $response;
} else {
    $response = json_encode(false);
    echo $response;
}
