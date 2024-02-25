<?php
	// Owner and Super owner
	
	include '../config.php';
	include '../classes/Owner.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$owner = new Owner(parseQuery());
	
	$ownerData = $owner->getOwnerData();
	
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	header("Access-Control-Allow-Hedares: X-Request-With");
	
	echo json_encode($ownerData);
	
	if ($ownerData === null) {
		json_encode($ownerData);
		return;
	}
?>