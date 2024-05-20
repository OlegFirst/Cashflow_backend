<?php	
	class GameSingelton {
		protected $userId = null;
		protected $gameId = null;
		protected $gamerIdList = [];
		
		protected $dataBaseController = null;
		protected $responseCreator = null;
		
		public function __construct($userId, $gameId, $gamerIdList, $dataBaseController, $responseCreator) {			
			$this->userId = $userId;
			$this->gameId = $gameId;
			$this->gamerIdList = $gamerIdList;
			
			$this->dataBaseController = $dataBaseController;
			$this->responseCreator = $responseCreator;
		}
		
		public function proceed() {
			return $this->setGamerTurn();
		}
		
		private function setGamerTurn() {
			$sql = "SELECT gamer_index_turn FROM game_info WHERE id='$this->gameId'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('gamer_index_turn error');
				return $this->responseCreator->getData();
			}
			
			$gamerIndexTurn = $results[0]['gamer_index_turn'] + 1;
			if ($gamerIndexTurn >= count($this->gamerIdList)) {
				$gamerIndexTurn = 0;
			}			
			$gamerIdTurn = $this->gamerIdList[$gamerIndexTurn];
			
			$sql = "UPDATE game_info SET 
				gamer_index_turn='$gamerIndexTurn', gamer_id_turn='$gamerIdTurn', is_gamer_turn_end = '1'
				WHERE id='$this->gameId'";			
			$results = $this->dataBaseController->setter($sql);
			if (!$results) {
				$this->responseCreator->setError('setGamerTurn error');
				return $this->responseCreator->getData();
			}
			
			return $gamerIdTurn;
		}
		
		public function moveGamerToPath($data) {
			$obj = json_decode($data['data']);
			$left = $obj->coordinates->left;
			$top = $obj->coordinates->top;
			$isSmallPath = $obj->isSmallPath;
			$gamerIdTurn = $obj->gamerIdTurn;
			
			// Check if gamer is moved to the same path
			$sql = "SELECT is_small_path FROM user_model WHERE gamer_id = '$gamerIdTurn'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Перехід на інше Коло нe успішний');
				return;
			}			
			if ($results[0]['is_small_path'] == $isSmallPath) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Гравець вже переведений на це коло');
				return;
			}
			
			// bigPathDataCorrection
			$this->bigPathDataCorrection($gamerIdTurn, $obj->gameId, $isSmallPath);
			
			// Update user_model
			$sql = "UPDATE user_model SET
				is_small_path = '$isSmallPath', path_position_id = '0', path_position_left = '$left', path_position_top = '$top',
				charity_turns_left = '0' WHERE gamer_id = '$gamerIdTurn'";
				
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Перехід на інше Коло нe успішний');
				return;
			}			
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Перехід на інше Коло успішний');
		}
		
		private function bigPathDataCorrection($gamerIdTurn, $gameId, $isSmallPath) {
			if ($isSmallPath) {
				return;
			}
			
			// Clear big path data
			$sqlArray = [];
			$sql = "DELETE FROM user_model_buyed_business WHERE gamer_id = '$gamerIdTurn'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_buyed_cash WHERE gamer_id = '$gamerIdTurn'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_buyed_dreams WHERE gamer_id = '$gamerIdTurn'";
			array_push($sqlArray, $sql);
			$this->dataBaseController->setterArray($sqlArray);
			
			// Get pasive incomes from the small path
			$sql = "SELECT result from user_model_arithmetic WHERE gamer_id = '$gamerIdTurn' AND property = 'incomes' AND sub_property = 'passive_incomes'";
			$results = $this->dataBaseController->getter($sql);
			$bigPathMoneyFlow = 0;
			if ($results) {
				$lastElement = end($results);			
				$smallPathPassiveIncomes = $lastElement['result'];
				$bigPathMoneyFlow = $smallPathPassiveIncomes * 100;
			}
			
			// Set big path money flow
			$sql = "INSERT INTO 
				user_model_buyed_business (gamer_id, game_id, name, passive_incomes, money_flow) 
				VALUES 
				('$gamerIdTurn', '$gameId', '', '0', '$bigPathMoneyFlow')";
			$results = $this->dataBaseController->setter($sql);
			if (!$results) {
				$this->responseCreator->setError('user_model_buyed_business-1 error');
				return $this->responseCreator->getData();
			}
			
			// Get cash from the small path
			$sql = "SELECT result from user_model_arithmetic WHERE gamer_id = '$gamerIdTurn' AND property = 'cash'";
			$results = $this->dataBaseController->getter($sql);
			$cash = 0;
			if ($results) {
				$lastElement = end($results);			
				$cash = $lastElement['result'];
			}
			
			// Set big path cash
			$sql = "INSERT INTO user_model_buyed_cash (gamer_id, game_id, value, result)
				VALUES ('$gamerIdTurn', '$gameId', '$cash', '$cash')";
			$results = $this->dataBaseController->setter($sql);
			if (!$results) {
				$this->responseCreator->setError('user_model_buyed_business-2 error');
				return $this->responseCreator->getData();
			}
		}
	}
?>