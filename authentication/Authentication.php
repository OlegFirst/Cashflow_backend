<?php
	include '../classes/DataBaseController.php';
	include '../get-messages/protocol.php';
	
	class ResultsCreator {
		private $results = [];
		
		function getData() {			
			return $this->results;
		}
		
		function getUserRole() {			
			return $this->results['user_info']['user_role_id'];
		}
		
		function setData($itemName, $data) {
			$this->results[$itemName] = $data;
		}
	}

	class Authentication {
		private $login = '';
		private $password = '';
		private $dataBaseController = null;
		
		function __construct($queryElements) {			
			if (array_key_exists('login', $queryElements)) {
				$this->login = $queryElements['login'];
			}
			
			if (array_key_exists('password', $queryElements)) {
				$this->password = $queryElements['password'];
			}
			
			$this->dataBaseController = new DataBaseController();
			$this->resultsCreator = new ResultsCreator();
		}
		
		function getUserData() {
			$sql = "SELECT id, name, user_role_id, game_id FROM users WHERE login = '$this->login' AND password = '$this->password'";			
			$results = $this->dataBaseController->getter($sql);
			
			if (!$results) {
				return $results;
			}
			
			$userId = $results[0]['id'];
			$this->resultsCreator->setData('user_info', $results[0]);
			
			$this->resultsCreator->setData('protocol', $GLOBALS['protocol']);
			
			// If user is an owner or super-owner
			if ($this->resultsCreator->getUserRole() !== '3') {
				return $this->resultsCreator->getData();
			}
			
			// Continue if user is a gamer
			$gameId = $results[0]['game_id'];
			$sql = "SELECT * FROM game_info WHERE id='$gameId'";
			$gameInfoResults = $this->dataBaseController->getter($sql);
			$this->resultsCreator->setData('game_info', $gameInfoResults[0]);
			
			$gameOwnerId = $gameInfoResults[0]['owner_id'];
			$sql = "SELECT name FROM users WHERE id='$gameOwnerId'";
			$gameOwnerName = $this->dataBaseController->getter($sql);
			$this->resultsCreator->setData('game_owner_name', $gameOwnerName[0]['name']);
			
			$sql = "SELECT users.id, users.name, user_model.color 
				FROM users INNER JOIN user_model
				ON users.id=user_model.gamer_id
				WHERE users.game_id='$gameId' AND users.user_role_id='3'";
			$results = $this->dataBaseController->getter($sql);
			$this->resultsCreator->setData('gamer_list', $results ?? []);
			
			return $this->resultsCreator->getData();
		}
	}
?>