<?php
	include 'Schema.php';
	include 'ResponseCreator.php';
	include 'DataBaseTablesClear.php';

	class Owner {
		private $name = '';
		private $login = '';
		private $password = '';
		protected $dataBaseController = null;
		protected $responseCreator = null;
		
		function __construct($queryElements) {
			if (array_key_exists('login', $queryElements)) {
				$this->login = $queryElements['login'];
			}
			
			if (array_key_exists('password', $queryElements)) {
				$this->password = $queryElements['password'];
			}
			
			$this->dataBaseController = new DataBaseController();
			$this->responseCreator = new ResponseCreator();
		}
		
		// Get owner data
		function getOwnerData() {
			$sql = "SELECT id, name, user_role_id, game_id FROM users WHERE login = '$this->login' AND password = '$this->password'";
			$results = $this->dataBaseController->getter($sql);
			
			return $results;
		}
		
		// Create new game for user_id
		function createNewGame($data) {
			$obj = json_decode($data['data']);

			$userId = $obj->user_id;
			$gameName = $obj->game->name;
			$gameDate = $obj->game->date;
			$gameTime = $obj->game->time;
			
			// - Create new game and connect the game to owner or super owner as owner_id
			$sql = "INSERT INTO game_info (owner_id, name, date, time) VALUES ('$userId', '$gameName', '$gameDate', '$gameTime')";
			
			$isSuccess = $this->dataBaseController->setter($sql);
			
			if (!$isSuccess) {
				return false;
			}
			
			// - Get id of the created game
			$sql = "SELECT id FROM game_info WHERE owner_id = '$userId' AND name = '$gameName'";			
			$result = $this->dataBaseController->getter($sql);
			$createdGameId = $result[0]['id'];
			
			// - Create gamers and connect to the game
			$sqlArray = array();
			
			foreach ($obj->gamerList as $item) {
				$name = $item->name;
				$login = $item->login;
				$password = $item->password;
				$userRoleId = 3;
				
				$sql = "INSERT INTO users (name, login, password, user_role_id, game_id) VALUES ('$name', '$login', '$password', '$userRoleId', '$createdGameId')";
				
				array_push($sqlArray, $sql);
			}
			
			$isSuccess = $this->dataBaseController->setterArray($sqlArray);
			
			return $isSuccess;
		}

		// Edit the game
		function editGame($data) {
			$obj = json_decode($data['data']);
			
			$gameId = $obj->game->gameId;
			$gameName = $obj->game->name;
			$gameDate = $obj->game->date;
			$gameTime = $obj->game->time;
			
			// - Update the game_info table
			$sql = "UPDATE game_info SET name = '$gameName', date = '$gameDate', time = '$gameTime' WHERE id = '$gameId'";			
			$isSuccess1 = $this->dataBaseController->setter($sql);
			
			// - Update created gamers or create new ones
			$sqlArray = array();			
			foreach ($obj->gamerList as $item) {
				$userId = $item->id;
				$name = $item->name;
				$login = $item->login;
				$password = $item->password;
				$userRoleId = 3;				
				if (!$userId) {
					$sql = "INSERT INTO users (name, login, password, user_role_id, game_id) VALUES ('$name', '$login', '$password', '$userRoleId', '$gameId')";
				} else {
					$sql = "UPDATE users SET name = '$name', login = '$login', password = '$password', user_role_id = '$userRoleId', game_id = '$gameId' WHERE id = '$userId'";
				}				
				array_push($sqlArray, $sql);
			}			
			$isSuccess2 = $this->dataBaseController->setterArray($sqlArray);
			
			// - Remove created gamers that are present in the request
			$sqlArray = array();			
			foreach ($obj->removedGamerList as $item) {
				$userId = $item->id;
				$sql = "DELETE FROM users WHERE id = '$userId'";
				array_push($sqlArray, $sql);
			}			
			$isSuccess3 = $this->dataBaseController->setterArray($sqlArray);
			
			return $isSuccess1 && $isSuccess2 && isSuccess3;
		}
		
		// Remove the game from
		function removeGame($data) {
			// $gameId = $data['game_id'];
			// $sqlArray = [];
			
			$dataBaseTablesClear = new DataBaseTablesClear(null, $data['game_id']);
			return $dataBaseTablesClear->removeGame();
			
			// $sql = "DELETE FROM game_info WHERE id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM msg WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM users WHERE game_id = '$gameId' AND user_role_id = '3'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_actions WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_arithmetic WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_assets_const WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);			
			// $sql = "DELETE FROM user_model_business WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_child_expenses_const WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_credit_liabilities_const WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_expenses_const WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_incomes_const WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_real_estate WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM cards WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_dream WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_total WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM cards_transfer WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM common_small_agreement WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);				
			// $sql = "DELETE FROM user_model_buyed_business WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $sql = "DELETE FROM user_model_buyed_dreams WHERE game_id = '$gameId'";
			// array_push($sqlArray, $sql);
			// $isSuccess = $this->dataBaseController->setterArray($sqlArray);
			
			// return $isSuccess;
		}
		
		// Get list of created games
		function getGames($data) {			
			$userId = $data['user_id'];
			$results = array();
			
			$sql = "SELECT * FROM game_info WHERE owner_id = '$userId'";
			$games = $this->dataBaseController->getter($sql);
			
			if (!$games) {
				return [];
			}
			
			foreach ($games as $game) {
				$gameId = $game['id'];				
				$sql = "SELECT * FROM users WHERE game_id = '$gameId'";
				$gamersData = $this->dataBaseController->getter($sql);
				
				$gameData = array(
					'game_id' => $game['id'],
					'name' => $game['name'],
					'date' => $game['date'],
					'time' => $game['time'],
					'is_game_begun' => $game['is_game_begun'],
					'gamers' => $gamersData
				);
				
				array_push($results, $gameData);
			}
			
			return $results;
		}
	}
?>