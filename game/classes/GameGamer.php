<?php
	class GameGamer extends Game {
		public function preparation() {			
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			$results = $userModel->getCreatedModel($this->responseCreator);
			
			return $results;
		}
		
		public function userModelInsert($data) {
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			return $userModel->insert($data, $this->responseCreator);
		}
		
		public function userModelUpdate($data) {
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			return $userModel->update($data, $this->responseCreator);
		}
		
		public function userModelRemove($data) {
			$userModel = new UserModel($this->userId, $this->gameId, $this->dataBaseController);
			return $userModel->remove($data, $this->responseCreator);
		}
		
		public function userModelBuyedInsert($data) {
			$userModelBuyed = new UserModelBuyed($this->userId, $this->gameId, $this->dataBaseController);			
			return $userModelBuyed->insert($data, $this->responseCreator);
		}
		
		public function gamerStartTurn() {
			$sql = "SELECT gamer_id_turn FROM game_info WHERE id = '$this->gameId'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('gamerStartTurn error');
				return $this->responseCreator->getData();
			}
			
			$canGamerStartTurn = $this->userId == $results[0]['gamer_id_turn'];
			$this->responseCreator->setData('is_gamer_can_start_turn', $canGamerStartTurn);

			$diceCount = null;
			
			if ($canGamerStartTurn) {
				// Set flag that turn of the Gamer is not completed ( is in progress )
				$sql = "UPDATE game_info SET is_gamer_turn_end = '0' WHERE id = '$this->gameId'";
				$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('is_gamer_turn_end error');
				return $this->responseCreator->getData();
			}
				
				// Charity
				$diceCount = 1;
				
				$sql = "SELECT is_small_path, charity_turns_left FROM user_model 
					WHERE gamer_id = '$this->userId'";
				$results = $this->dataBaseController->getter($sql);
				if (!$results) {
					$this->responseCreator->setError('gamerStartTurn error');
					return $this->responseCreator->getData();
				}
				
				if ($results[0]['charity_turns_left'] > 0) {
					if ($results[0]['is_small_path']) {
						$diceCount = 2;
					} else {
						$diceCount = 3;
					}
				}
				
				$this->responseCreator->setData('dice_count', $diceCount);
			}
			
			$this->responseCreator->setData('dice_count', $diceCount);
			
			return $this->responseCreator->getData();
		}
		
		public function gamerEndTurn() {
			$sql="UPDATE game_info SET gamer_id_turn = '0', is_gamer_turn_end = '1' WHERE id = '$this->gameId'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('gamerEndTurn error');
				return $this->responseCreator->getData();
			}
			
			$this->responseCreator->setData('', $isSuccess);			
			return $this->responseCreator->getData();
		}
		
		public function gamerGetAgreement($data) {
			$obj = json_decode($data['data']);
			$this->getAgreement($obj->type);
			return $this->responseCreator->getData();
		}
		
		public function gamerRemoveAgreement($data) {
			$obj = json_decode($data['data']);
			$id = $obj->id;
			
			$sql = "SELECT * FROM cards_transfer WHERE id = '$id'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('gamerRemoveAgreement error');
				return $this->responseCreator->getData();
			}
			
			if ($results[0]['gamer_id_redirect'] > 0) {
				return $this->responseCreator->getData();
			}
			
			$sql = "DELETE FROM cards_transfer WHERE id = '$id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('gamerRemoveAgreement error');
			}
			
			return $this->responseCreator->getData();
		}
		
		public function gamerSellAgreement($data) {
			$obj = json_decode($data['data']);
			
			$sql = "UPDATE cards_transfer SET gamer_id_redirect = '$obj->gamerIdRedirect' WHERE id = '$obj->id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('gamerRemoveAgreement error');
			}
			
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Картка прoдана');
			return $this->responseCreator->getData();
		}
		
		public function gamerBuyAgreement($data) {
			$obj = json_decode($data['data']);
			
			$sql = "SELECT * FROM cards_transfer WHERE id = '$obj->id'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('gamerRemoveAgreement error');
				return $this->responseCreator->getData();
			}
			
			if ($results[0]['gamer_id_redirect'] != $this->userId) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Неможливо придбати');
				return $this->responseCreator->getData();
			}
			
			$sql = "DELETE FROM cards_transfer WHERE id = '$obj->id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('cards_transfer removeAgreement error');
				return $this->responseCreator->getData();
			}
			
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Картка придбана');
			return $this->responseCreator->getData();
		}
		
		public function setFishkaPosition($data) {
			$obj = json_decode($data['data']);
			$left = $obj->coordinates->left;
			$top = $obj->coordinates->top;
			
			$sql = "UPDATE user_model SET 
				is_small_path = '$obj->isSmallPath', path_position_id = '$obj->pathPositionId',
				path_position_left = '$left', path_position_top = '$top'
				WHERE gamer_id = '$this->userId'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('setFishkaPosition error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
		
		public function getDream() {
			$sql = "SELECT big_path_position_id, title, price FROM user_model_dream WHERE gamer_id='$this->userId'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('user_model_dream error');
				return $this->responseCreator->getData();
			}
			$this->responseCreator->setData('user_model_dream', $results[0]);
			
			return $this->responseCreator->getData();
		}
		
		public function setDream($data) {
			$obj = json_decode($data['data']);
			
			$sql = "UPDATE user_model_dream 
							SET big_path_position_id = '$obj->bigPathId', title = '$obj->title', price = '$obj->price'
							WHERE gamer_id = '$obj->userId'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('setDream error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
	}
?>