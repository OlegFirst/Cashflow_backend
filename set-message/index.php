<?php
	// Set message
	
	include '../config.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 404 Bad request method");
		return;
	}
	
	$queryElements = parseQuery();
	
	print_r($queryElements);
	
	
?>