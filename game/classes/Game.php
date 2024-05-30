<?php
	include 'Utils.php';

	class Game {
		
		//
		// N.B. 
		// - These variables are accessible in the GameOwner and GameGamer classes
		// - $userId can be anyone
		//
		
		protected $userId = null;
		protected $gameId = null;
		protected $userRoleId = null;
		
		protected $cardConstructor = null;
		protected $dataBaseController = null;
		protected $responseCreator = null;
		
		protected $Utils = null;
		
		public function __construct($data) {
			$obj = json_decode($data['data']);
			
			$this->userId = $obj->userId;
			if (isset($obj->gameId)) {
				$this->gameId = $obj->gameId;
			}			
			$this->userRoleId = $obj->userRoleId;
			
			$this->dataBaseController = new DataBaseController();
			$this->responseCreator = new ResponseCreator();
			$this->cardConstructor = new CardConstructor($this->gameId, $this->dataBaseController);
			
			$this->Utils = new Utils($this->dataBaseController, $this->responseCreator);
		}
		
		protected function getGamerIdList() {		
			$gamerIdList = [];
			$sql = "SELECT id FROM users WHERE game_id = '$this->gameId' AND user_role_id = '3'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError();
				return $this->responseCreator->getData();
			}
			
			foreach ($results as $item) {
				array_push($gamerIdList, $item['id']);
			}
			
			return $gamerIdList;
		}
		
		protected function getAgreement($type) {			
			$sql = "SELECT * FROM cards_transfer WHERE game_id = '$this->gameId' AND card_type = '$type'";						
			$results = $this->dataBaseController->getter($sql);
			
			if (!$results) {
				$this->responseCreator->setError('gamerGetAgreement error');
				return $this->responseCreator->getData();			
			}
			
			$this->responseCreator->setData('cards_transfer', $results[0]);
			
			return $this->responseCreator->getData();
		}
		
		public function waitingConnection() {
			$waitingConnection = new WaitingConnection(
				$this->gameId, $this->dataBaseController, $this->responseCreator
			);
			
			return $waitingConnection->get();
		}
		
		public function setWaitingConnection($data) {
			$obj = json_decode($data['data']);
			
			$waitingConnection = new WaitingConnection(
				$this->gameId, $this->dataBaseController, $this->responseCreator
			);
			
			return $waitingConnection->set($obj->marketId);
		}
	}
?>