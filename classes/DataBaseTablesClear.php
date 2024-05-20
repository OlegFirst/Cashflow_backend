<?php
	class DataBaseTablesClear {
		private $userId = null;
		private $gameId = null;
		
		private $dataBaseController = null;
		// private $responseCreator = null;
		
		public function __construct($userId, $gameId) {
			$this->userId = $userId;
			$this->gameId = $gameId;
			
			$this->dataBaseController = new DataBaseController();
			// $this->responseCreator = new ResponseCreator();
		}
		
		public function gamerBunkrupt() {
			$sqlArray = [];
			
			$sql = "DELETE FROM user_model WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_actions WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_arithmetic WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_assets_const WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);			
			$sql = "DELETE FROM user_model_business WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_child_expenses_const WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_credit_liabilities_const WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_expenses_const WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_incomes_const WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_real_estate WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM cards WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_dream WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_total WHERE gamer_id = '$this->userId'";
			array_push($sqlArray, $sql);
						
			$this->dataBaseController->setterArray($sqlArray);
		}
		
		public function removeGame($data) {
			$gameId = $data['game_id'];
			$sqlArray = [];
			
			$sql = "DELETE FROM game_info WHERE id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM msg WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM users WHERE game_id = '$gameId' AND user_role_id = '3'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_actions WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_arithmetic WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_assets_const WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);			
			$sql = "DELETE FROM user_model_business WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_child_expenses_const WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_credit_liabilities_const WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_expenses_const WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_incomes_const WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_real_estate WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM cards WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_dream WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_total WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM cards_transfer WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM common_small_agreement WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);				
			$sql = "DELETE FROM user_model_buyed_business WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$sql = "DELETE FROM user_model_buyed_dreams WHERE game_id = '$gameId'";
			array_push($sqlArray, $sql);
			$isSuccess = $this->dataBaseController->setterArray($sqlArray);
			
			return $isSuccess;
		}
	}
?>