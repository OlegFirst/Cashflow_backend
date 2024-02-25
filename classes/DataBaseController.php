<?php
	class DataBaseController {
		function getter($sql) {
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			$results = $connection->query($sql);
			
			$matrix = array();
			
			if ($results && $results->num_rows > 0) {				
				while($row = $results->fetch_assoc()) {
					array_push($matrix, $row);
				}
			}
			
			$connection->close();			
			
			return count($matrix) > 0 ? $matrix : null;
		}
		
		function getterArray($sqlArray) {
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			$resultArray = [];
			
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			foreach ($sqlArray as $sql) {				
				$results = $connection->query($sql);
				
				$matrix = array();
				if ($results && $results->num_rows > 0) {				
					while($row = $results->fetch_assoc()) {
						array_push($matrix, $row);
					}
				}
				
				array_push($resultArray, $matrix);
			}
			
			$connection->close();;
			
			return $resultArray;
		}
		
		function checkDataPresent($sql) {
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			$results = $connection->query($sql);
			
			$connection->close();
			
			return $results && $results->num_rows > 0 ? true : false;
			
			$connection->close();
		}
		
		function setter($sql) {			
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
						
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			$isSuccess = $connection->query($sql);
			
			$connection->close();
			
			return $isSuccess;
		}
		
		function setterArray($sqlArray) {
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			$isSuccess = true;
			
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			foreach ($sqlArray as $sql) {
				$result = $connection->query($sql);
				$isSuccess = $result ? $isSuccess : false;
			}
			
			$connection->close();			
			
			return $isSuccess;
		}
	}
?>