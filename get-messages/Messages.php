<?php		
	class Messages {
		private $gameId = null;
		private $userId = null;
		private $dataBaseController = null;
		
		function __construct($userId, $gameId) {
			$this->userId = $userId;
			$this->gameId = $gameId;
			
			$this->dataBaseController = new DataBaseController();
		}
		
		function setMessage($message) {
			$timeStamp = $this->createTimestamp();
			
			$sql = "INSERT INTO msg (game_id, user_id, message, time_stamp) VALUES ('$this->gameId', '$this->userId', '$message', '$timeStamp')";			
			$isSuccess = $this->dataBaseController->setter($sql);
			
			return $isSuccess;
		}
		
		function getMessages() {
			$date = new DateTimeImmutable();
			$timeStamp = $date->getTimestamp();
			$matrix = array();
			
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			// Get the newest message
			$sql = "SELECT * FROM msg WHERE time_stamp > '" . $timeStamp . "'";
			
			while(true) {
				$results = $connection->query($sql);
				$currentTimeStamp = $date->getTimestamp();
				
				if ($results && $results->num_rows > 0) {							
					while($row = $results->fetch_assoc()) {						
						if ($row['game_id'] === $this->gameId) {
							array_push($matrix, $row);
						}
					}
					
					if (count($matrix) > 0) {
						break;
					}
				}
				
				if ($currentTimeStamp - $timeStamp > 10) {
					break;
				}
				
				sleep(2);
			}
			
			$connection->close();
			return $matrix;
		}
		
		function createTimestamp() {
			$date = new DateTimeImmutable();
			$timeStamp = $date->getTimestamp();
			
			return $timeStamp;
		}
		
		function createConnection() {
			$connection = new mysqli($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['password'], $GLOBALS['dataBaseName']);
			if ($connection->connect_error) {
				die('Connection failed: ' . $connection->connect_error);
			}
			
			return $connection;
		}
	}
?>