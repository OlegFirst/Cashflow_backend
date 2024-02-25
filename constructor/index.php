<?php
	// Data base constructor
	
	include '../config.php';
	include './TablesContent.php';
	include '../classes/DataBaseController.php';
	include '../classes/Schema.php';
	include '../classes/ResponseCreator.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$queryElements = parseQuery();	
	$tablesContent = new TablesContent();
	$results = null;
	
	switch ($queryElements['info']) {
		case 'content':
			$results = $tablesContent->proceed();
			break;
			
		default:
			echo 'Bad constructor request';
	}
	
	if ($results && $results['isSuccess']) {
		echo json_encode($results['data']);
		return;
	}
	
	header("HTTP/1.1 500 Failed");	
	echo json_encode(null);
?>