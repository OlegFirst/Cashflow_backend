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
			
			$sql = "UPDATE user_model SET
				is_small_path = '$obj->isSmallPath', path_position_id = '0', path_position_left = '$left', path_position_top = '$top', charity_turns_left = '0'
				WHERE gamer_id = '$obj->gamerIdTurn'";				
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Перехід на інше Коло нe успішний');
				return;
			}
			
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Перехід на інше Коло успішний');
		}
	}
?>