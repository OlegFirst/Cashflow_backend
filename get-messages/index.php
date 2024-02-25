<?php
	// Messages
	
	include '../config.php';
	include '../classes/DataBaseController.php';
	include './Messages.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$queries = parseQuery();
	
	$messages = new Messages(null, $queries['gameId']);
	$results = $messages->getMessages();
	
	echo json_encode($results);
?>