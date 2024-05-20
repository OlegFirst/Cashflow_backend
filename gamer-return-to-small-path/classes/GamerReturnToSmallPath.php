<?php
	/*
	*	@Values from the Parent Class
	*
	*	protected $userId = null;
	*	protected $gameId = null;
	*	protected $color = null;
	*	
	*	protected $dataBaseController = null;
	*	protected $responseCreator = null;
	*	protected $DataBaseTablesClear = null;
	*/

	class GamerReturnToSmallPath extends GamerBankrupt {
		public $cash = null;
		
		public function storeCash() {
			$sql = "SELECT result FROM user_model_arithmetic WHERE property = 'cash' AND gamer_id = '$this->userId'";			
			$results = $this->dataBaseController->getter($sql);
			
			if (!$results) {
				$this->cash = 0;
			} else {				
				$this->cash = end($results)['result'];
			}
		}
		
		public function saveCash() {
			$sql = "INSERT INTO user_model_arithmetic (gamer_id, game_id, property, sub_property, value, result) VALUES 
								('$this->userId', '$this->gameId', 'cash', '-1', '$this->cash', '$this->cash')";
			$this->dataBaseController->setter($sql);
		}
	}
?>