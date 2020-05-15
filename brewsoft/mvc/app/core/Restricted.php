<?php

function restricted ($controller, $method) {

	$restricted_urls = array(
		'HomeController' => array('logout'),
		'ApiController' => array(),
		'ManagerController' => array('index', 'batchQueue', 'planBatch', 'editBatch', 'completedBatches', 'displayOeeForBatch', 'displayOeeForDay', 'batchReport', 'restricted', 'logout'),
		'MachineApiController' => array('restricted', 'logout'),
		'AdminController' => array('restricted', 'logout')
	);

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		return false;
	} else if( isset($controller) && in_array($method, $restricted_urls[$controller])) {
		return true;
	} else {
		return false;
	}
}
