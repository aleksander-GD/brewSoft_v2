<?php

function restricted($controller, $method)
{

	$restricted_urls = array(
		'HomeController' => array('logout'),
		'ApiController' => array(),
		'ManagerController' => array('index', 'batchQueue', 'planBatch', 'editBatch', 'completedBatches', 'displayOeeForBatch', 'displayOeeForDay', 'batchReport', 'logout'),
		'MachineApiController' => array('machineControls','logout'),
		'AdminController' => array('index', 'logout')
	);

	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		return false;
	} else if (isset($controller) && in_array(strtolower($method), array_map('strtolower', $restricted_urls[$controller]))) {
		return true;
	} else {
		return false;
	}
}
