<?php
	// Authentication
	
	include '../config.php';
	include './Authentication.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$queryElements = parseQuery();
	
	$authentication = new Authentication($queryElements);
	$userData = $authentication -> getUserData();
	
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	header("Access-Control-Allow-Hedares: X-Request-With");
	
	echo json_encode($userData);
?>