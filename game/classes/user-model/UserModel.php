<?php
	class UserModel {
		private $gamerId = null;
		private $gameId = null;
		private $dataBaseController = null;
		
		public function __construct($gamerId, $gameId, $dataBaseController) {
			$this->gamerId = $gamerId;
			$this->gameId = $gameId;
			$this->dataBaseController = $dataBaseController;
		}
		
		public function setNewModel($profession, $color) {
			return UserModelConstructor::create($this->gamerId, $this->gameId, $profession, $color, $this->dataBaseController);
		}
		
		public function getCreatedModel($responseCreator) {
			return UserModelConstructor::read($this->gamerId, $this->dataBaseController, $responseCreator);
		}
		
		public function insert($data, $responseCreator) {
			$obj = json_decode($data['data']);
			
			$sqlArray = [];			
			foreach($obj->data->valueList as $item) {
				$sql = Insert::sqlCreatorInsertValueList($this->gamerId, $this->gameId, $obj, $item);
				array_push($sqlArray, $sql);
			}
			
			$isSuccess = $this->dataBaseController->setterArray($sqlArray);
			if (!$isSuccess) {
				$responseCreator->setError('insert error');
			}
			
			return $responseCreator->getData();
		}
		
		public function update($data, $responseCreator) {
			$obj = json_decode($data['data']);
			
			// valueList
			$sqlArray = [];
			foreach($obj->data->valueList as $item) {
				$sql = Insert::sqlCreatorUpdateValueList($this->gamerId, $obj->type, $item);
				array_push($sqlArray, $sql);
			}			
			$isSuccess = $this->dataBaseController->setterArray($sqlArray);
			if (!$isSuccess) {
				$responseCreator->setError('update error');
				return $responseCreator->getData();
			}
			
			if (
				$obj->type === ProfessionCardTypes::ARITHMETIC ||
				$obj->type === ProfessionCardTypes::BUYED_DREAMS ||
				$obj->type === ProfessionCardTypes::BUYED_BUSINESS ||
				$obj->type === ProfessionCardTypes::BUYED_CASH
			) {
				return $responseCreator->getData();
			}
			
			// total
			$sql = Insert::sqlCreatorUpdateTotal($this->gamerId, $obj->type, $obj->data->total);
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$responseCreator->setError('update error');
				return $responseCreator->getData();
			}
			
			return $responseCreator->getData();
		}
		
		public function remove($data, $responseCreator) {
			$obj = json_decode($data['data']);
			
			$sqlArray = [];			
			foreach($obj->data->valueList as $item) {
				$sql = Insert::sqlCreatorRemoveValueList($this->gamerId, $obj->type, $item);
				array_push($sqlArray, $sql);
			}			
			$isSuccess = $this->dataBaseController->setterArray($sqlArray);			
			if (!$isSuccess) {
				$responseCreator->setError('remove error');
			}
			
			return $responseCreator->getData();
		}
	}
?>