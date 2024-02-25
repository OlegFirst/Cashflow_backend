<?php
	class GamerBankrupt {
		private $userId = null;
		private $gameId = null;
		private $color = null;
		
		private $dataBaseController = null;
		private $responseCreator = null;
		
		public function __construct($data) {
			$obj = json_decode($data['data']);
			
			$this->userId = $obj->userId;
			$this->gameId = $obj->gameId;
			
			$this->dataBaseController = new DataBaseController();
			$this->responseCreator = new ResponseCreator();
		}
		
		public function procced() {
			$sql = "SELECT color from user_model WHERE gamer_id = '$this->userId'";
			$results = $this->dataBaseController->getter($sql);			
			if (!$results) {
				$this->responseCreator->setError('get color error');
				return $this->responseCreator->getData();
			}			
			$this->color = $results[0]['color'];
			
			// Remove all the bankruted gamer data except nessesary one
			$this->removeGamerModel();
			
			// Clear data
			$this->clearData();
			
			// Create new profession
			$newProfession = $this->createNewProfession();
			
			// Create new profession Model
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			$isSuccess = $userModel->setNewModel($newProfession, $this->color);
			
			return $this->responseCreator->getData();
		}
		
		private function removeGamerModel() {
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
		
		private function clearData() {
			$sql = "UPDATE cards_transfer SET gamer_id_redirect = '-1' WHERE gamer_id_turn = '$this->userId'";
			$this->dataBaseController->setter($sql);
			
			// $sql = "UPDATE user_model 
						// SET profession_name = '', is_small_path = '1', path_position_id = '0', path_position_left = '0px', path_position_top = '0px', charity_turns_left = '0'
						// WHERE gamer_id = '$this->userId'";
			// $this->dataBaseController->setter($sql);
		}
		
		private function createNewProfession() {			
			$sql = "SELECT profession_id FROM user_model WHERE game_id = '$this->gameId'";
			$usedProfesionIdList = $this->dataBaseController->getter($sql) ?? [1];

			$professions = new Professions();
			$newProfession = $professions->getBankruptedGamerNewProfession($usedProfesionIdList);
			
			return $newProfession;
		}
	}
?>