<?php
	class GamerBankrupt {
		protected $userId = null;
		protected $gameId = null;
		protected $color = null;
		protected $usedProfesionIdList = null;
		
		protected $dataBaseController = null;
		protected $responseCreator = null;
		protected $DataBaseTablesClear = null;
		
		public function __construct($data) {
			$obj = json_decode($data['data']);
			
			$this->userId = $obj->userId;
			$this->gameId = $obj->gameId;
			
			$this->dataBaseController = new DataBaseController();
			$this->responseCreator = new ResponseCreator();
			$this->DataBaseTablesClear = new DataBaseTablesClear($obj->userId, $obj->gameId);
		}
		
		public function proceed() {
			// Get used professions id
			$sql = "SELECT profession_id FROM user_model WHERE game_id = '$this->gameId'";
			$this->usedProfesionIdList = $this->dataBaseController->getter($sql) ?? [[ 'profession_id' => 1 ]];						
			if (!$this->usedProfesionIdList) {
				$this->responseCreator->setError('get profession_id error');
				return $this->responseCreator->getData();
			}			
			
			// Get user color
			$sql = "SELECT color from user_model WHERE gamer_id = '$this->userId'";
			$results = $this->dataBaseController->getter($sql);			
			if (!$results) {
				$this->responseCreator->setError('get color error');
				return $this->responseCreator->getData();
			}			
			$this->color = $results[0]['color'];
			
			// Remove all the bankrupted gamer data except nessesary one
			$this->DataBaseTablesClear->gamerBunkrupt();
			
			// Clear data
			$this->clearData();
			
			// Create new profession
			$newProfession = $this->createNewProfession();
			
			// Create new profession Model
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			$isSuccess = $userModel->setNewModel($newProfession, $this->color);
			
			return $this->responseCreator->getData();
		}
		
		protected function clearData() {
			$sql = "UPDATE cards_transfer SET gamer_id_redirect = '-1' WHERE gamer_id_turn = '$this->userId'";
			$this->dataBaseController->setter($sql);
		}
		
		protected function createNewProfession() {
			$professions = new Professions();
			$newProfession = $professions->getBankruptedGamerNewProfession($this->usedProfesionIdList);
			
			return $newProfession;
		}
	}
?>