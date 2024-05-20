<?php	
	class GameOwner extends Game {
		public function preparation() {			
			// Get started game
			$sql = "SELECT * FROM game_info WHERE owner_id = '$this->userId' AND is_game_begun = " . GameProcessingModes::START;
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('GameOwner->preparation. Get started game error');
				return $this->responseCreator->getData();
			}
			$this->responseCreator->setData('game_info', $results[0]);
			
			$gameId = $results[0]['id'];
			$this->gameId = $gameId;
			$isGamePrepared = $results[0]['is_game_prepared'];
			
			// Get list of the gamers
			$gamerIdList = [];
			$sql = "SELECT * FROM users WHERE game_id = '$gameId' AND user_role_id = '3'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('GameOwner->preparation. Get list of the gamers error');
				return $this->responseCreator->getData();
			}
			foreach ($results as $item) {
				array_push($gamerIdList, $item['id']);
			}
			
			// Set gamerId = 0 as default value for the first turn
			if (!$isGamePrepared) {
				$sql = "UPDATE game_info SET gamer_index_turn='-1' WHERE id='$gameId'";
				$isSuccess = $this->dataBaseController->setter($sql);
				if (!$isSuccess) {
					$this->responseCreator->setError('GameOwner->preparation. gamer_id_turn prepare error');
					return $this->responseCreator->getData();
				}
			}
			
			// Create UserModels for gamers_(start)
			if (!$isGamePrepared) {				
				// - Card
				$isSuccess = $this->cardConstructor->createRNDCardLists($gameId, CardTypes::ALL_TYPES);
				if (!$isSuccess) {
					$this->responseCreator->setError('GameOwner->preparation. createRNDCardLists error');
					return $this->responseCreator->getData();
				}
				
				// - Colors
				$colorList = ['green', 'red', 'grey', 'brown', 'yellow', 'blue', 'white', 'aqua', 'bisque', 'coral'];
				
				// - Professions
				$professions = new Professions();
				$usersProfessionList = $professions->getUsersProfessionList(count($gamerIdList));
				
				$isSuccess = true;
				$index = 0;
				
				foreach ($gamerIdList as $gamerId) {
					$userModel = new UserModel($gamerId, $gameId, $this->dataBaseController);
					$isSuccess = $userModel->setNewModel(array_pop($usersProfessionList), $colorList[$index]) ? $isSuccess : false;					
					$index++;
				}
				
				if (!$isSuccess) {
					$this->responseCreator->setError('GameOwner->preparation. not prepared error');
					return $this->responseCreator->getData();
				}				
				$this->preparationGetSomeGamerInformation();
				
				// - Save that this game is prepared
				$sql = "UPDATE game_info SET is_game_prepared='1' WHERE id='$gameId'";
				$isSuccess = $this->dataBaseController->setter($sql);
				if (!$isSuccess) {
					$this->responseCreator->setError('GameOwner->preparation. update is prepared error');
					return $this->responseCreator->getData();
				}
			} else {
				// - Get prepared data				
				$this->preparationGetSomeGamerInformation();
			}			
			// Create UserModels for gamers_(end)
			
			return $this->responseCreator->getData();
		}
		
		private function preparationGetSomeGamerInformation() {			
			// Get gamers id, name and color and fishka coordinates	
			$sql = "SELECT users.id, users.name, user_model.color,
				user_model.path_position_left, user_model.path_position_top
				FROM users INNER JOIN user_model ON users.id = user_model.gamer_id
				WHERE users.game_id = '$this->gameId' AND users.user_role_id = '3'";	
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('get color error');
				return $this->responseCreator->getData();
			}			
			$this->responseCreator->setData('gamer_list', $results);
			
			// Get current Gamer Id
			$gamerIdList = $this->getGamerIdList();
			$sql = "SELECT gamer_index_turn FROM game_info WHERE id='$this->gameId'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('gamer_index_turn error');
				return $this->responseCreator->getData();
			}
			$gamerIndexTurn = $results[0]['gamer_index_turn'];
			$gamerIdTurn = $gamerIndexTurn == -1 ? $gamerIdList[0] : $gamerIdList[$gamerIndexTurn];
			$this->responseCreator->setData('gamer_id_turn', $gamerIdTurn);
			
			// Get Gamer Turn information
			$this->Utils->getGamerTurnInformation($gamerIdTurn);
		}
		
		public function checkMakeNextTurn() {
			$sql = "SELECT * FROM game_info WHERE id = '$this->gameId'";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('get card error');
				return $this->responseCreator->getData();
			}			
			$this->responseCreator->setData('is_gamer_turn_end', $results[0]['is_gamer_turn_end']);
			
			return $this->responseCreator->getData();
		}
		
		public function makeNextTurn() {
			$gamerIdList = $this->getGamerIdList();			
			$gameSingelton = new GameSingelton($this->userId, $this->gameId, $gamerIdList, $this->dataBaseController, $this->responseCreator);			
			$gamerIdTurn = $gameSingelton->proceed();
			
			$this->responseCreator->setData('gamer_id_turn', $gamerIdTurn);
			
			$this->Utils->getGamerTurnInformation($gamerIdTurn, true);
			
			return $this->responseCreator->getData();
		}
		
		public function moveGamerToPath($data) {
			$gameSingelton = new GameSingelton($this->userId, $this->gameId, null, $this->dataBaseController, $this->responseCreator);			
			$gamerIdTurn = $gameSingelton->moveGamerToPath($data);
			
			return $this->responseCreator->getData();
		}
		
		public function sendAgreementToGamer($data) {
			$obj = json_decode($data['data']);
			$type = $obj->type;			
			
			// Check if the Agreement has been already sent_(start)
			$sql = "SELECT * FROM cards_transfer WHERE 
				gamer_id_turn = '$obj->gamerIdTurn' AND game_id = '$obj->gameId'
			";
			$results = $this->dataBaseController->getter($sql);
			if ($results && count($results) > 0) {
				$this->responseCreator->setData('is_complete', '0');
				$this->responseCreator->setData('complete_message', 'Картка надіслана');
				return $this->responseCreator->getData();
			}
			// Check if the Agreement has been already sent_(end)
			
			$sql = "SELECT id, card_id, type FROM cards WHERE game_id = '$this->gameId' AND type = '$type'";						
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('get card error');
				return $this->responseCreator->getData();
			}
			
			$id = $results[0]['id'];
			$cardId = $results[0]['card_id'];
			$cardArrayLength = count($results);
			
			$this->responseCreator->setData('gamer_id_turn', $obj->gamerIdTurn);
			$this->responseCreator->setData('game_id', $this->gameId);
			$this->responseCreator->setData('card_id', $cardId);
			$this->responseCreator->setData('card_type', $type);
			
			$sql = "DELETE FROM cards WHERE id = '$id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('delete card error');
				return $this->responseCreator->getData();
			}
			
			$sql = "INSERT INTO cards_transfer (gamer_id_turn, gamer_id_redirect, game_id, card_id, card_type)
				VALUES ('$obj->gamerIdTurn', '0', '$this->gameId', '$cardId', '$type')";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('INSERT INTO cards_transfer error');
				return $this->responseCreator->getData();
			}
			
			$this->getAgreement($type);
			
			if ($cardArrayLength > 2) {				
				return $this->responseCreator->getData();
			}
			
			// Create new RND array of agreements
			$isSuccess = $this->cardConstructor->createRNDCardLists($this->gameId, $type);
			if (!$isSuccess) {
				$this->responseCreator->setError('createRNDCardLists error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
		
		public function sendCommonAgreementToGamer($data) {
			$obj = json_decode($data['data']);
			
			$sql = "INSERT INTO common_small_agreement (game_id, small_agreement_id) 
				VALUES ('$obj->gameId', '$obj->cardId')";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('INSERT INTO common_small_agreement error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
		
		public function removeAgreementFromGamer($data) {
			$obj = json_decode($data['data']);			
			$smallAgreement = CardTypes::SMALL_AGREEMENT;
			$bigAgreement = CardTypes::BIG_AGREEMENT;
			
			$sql = "DELETE FROM cards_transfer WHERE
				gamer_id_turn = '$obj->gamerIdTurn' AND game_id = '$obj->gameId' 
				OR card_type='$smallAgreement' OR card_type='$bigAgreement'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('removeAgreementFromGamer error');
			} else {
				$this->responseCreator->setData('is_complete', '1');
				$this->responseCreator->setData('complete_message', 'Картка видалена');
			}
			
			return $this->responseCreator->getData();
		}
		
		public function getMarket() {			
			$type = CardTypes::MARKET;
			
			$sql = "SELECT id, card_id FROM cards WHERE game_id = '$this->gameId' AND type = '$type'";						
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('get card error');
				return $this->responseCreator->getData();
			}
			
			$id = $results[0]['id'];
			$cardId = $results[0]['card_id'];
			$cardArrayLength = count($results);
			
			$this->responseCreator->setData('card_id', $cardId);
			
			$sql = "DELETE FROM cards WHERE id = '$id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('delete card error');
				return $this->responseCreator->getData();
			}
			
			if ($cardArrayLength > 2) {				
				return $this->responseCreator->getData();
			}
			
			// Create new RND array of agreements
			$isSuccess = $this->cardConstructor->createRNDCardLists($this->gameId, $type);
			if (!$isSuccess) {
				$this->responseCreator->setError('createRNDCardLists error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
		
		public function getMoneyInTheWind() {
			$type = CardTypes::MONEY_IN_THE_WIND;
			
			$sql = "SELECT id, card_id FROM cards WHERE game_id = '$this->gameId' AND type = '$type'";						
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('get card error');
				return $this->responseCreator->getData();
			}
			
			$id = $results[0]['id'];
			$cardId = $results[0]['card_id'];
			$cardArrayLength = count($results);
			
			$this->responseCreator->setData('card_id', $cardId);
			
			$sql = "DELETE FROM cards WHERE id = '$id'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('delete card error');
				return $this->responseCreator->getData();
			}
			
			if ($cardArrayLength > 2) {				
				return $this->responseCreator->getData();
			}
			
			// Create new RND array of agreements
			$isSuccess = $this->cardConstructor->createRNDCardLists($this->gameId, $type);
			if (!$isSuccess) {
				$this->responseCreator->setError('createRNDCardLists error');
				return $this->responseCreator->getData();
			}
			
			return $this->responseCreator->getData();
		}
		
		public function setCharityTurnsLeft($data) {
			$obj = json_decode($data['data']);
			
			$sql = "UPDATE user_model SET charity_turns_left = '$obj->charityTurnsLeft' WHERE gamer_id = '$obj->gamerIdTurn'";			
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('SET charity_turns_left error');
				return $this->responseCreator->getData();
			}			
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Подія Благодійність активована');
			
			return $this->responseCreator->getData();
		}
		
		public function setGamerBankrupt($data) {
			$obj = json_decode($data['data']);			
			$sql = "UPDATE user_model SET is_bankrupt = '1' WHERE gamer_id = '$obj->gamerIdTurn'";
			
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('SET is_bankrupt error');
				return $this->responseCreator->getData();
			}
			$this->responseCreator->setData('is_complete', '1');
			$this->responseCreator->setData('complete_message', 'Гравець переведений у банкрутство');
			
			return $this->responseCreator->getData();
		}
	}
?>