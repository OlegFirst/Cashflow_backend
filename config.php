<?php
	// $header = header("Access-Control-Allow-Origin: *");

	$serverName = 'localhost';
	$userName = 'root';
	$password ='';
	$dataBaseName = 'cashflow';
	
	// $serverName = 'ux523827.mysql.tools';
	// $userName = 'ux523827_db';
	// $password = 'jdNsh48Z';
	// $dataBaseName = 'ux523827_db';
		
	function parseQuery() {
		parse_str($_SERVER['QUERY_STRING'], $queryElements);
		return $queryElements;
	}
	
	function printR($title = '', $value) {
		echo $title.'= ';
		print_r($value);
		echo '</br>';
	}
	
	function print_($title = '', $value) {
		echo $title.'= ';
		echo $value;
		echo '</br>';
	}
	
	function createResultsStatus($isSuccess) {
		if (!$isSuccess) {
			header("HTTP/1.1 500 Failed");
		}
		return $isSuccess === true ? 'Success' : 'Failed';
	}
	
	// header('Access-Control-Allow-Origin: *');
	// header('Access-Control-Allow-Methods: GET, POST');
	// header("Access-Control-Allow-Headers: X-Requested-With");
	// header("HTTP/1.1 200 OK");
?>