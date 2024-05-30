<?php
	class WaitingConnection {		
		private $gameId = null;
		
		private $dataBaseController = null;
		private $responseCreator = null;
		
		public function __construct($gameId, $dataBaseController, $responseCreator) {
			$this->gameId = $gameId;
			$this->dataBaseController = $dataBaseController;
			$this->responseCreator = $responseCreator;
		}
		
		public function get() {
			$sqlArray = [];
			
			$sql = "SELECT 
				gamer_id, is_small_path, path_position_id, color, path_position_left, path_position_top, is_bankrupt
				FROM user_model WHERE game_id = '$this->gameId'";
			array_push($sqlArray, $sql);
			
			$sql = "SELECT is_game_begun FROM game_info WHERE id = '$this->gameId'";
			array_push($sqlArray, $sql);
			
			$sql = "SELECT small_agreement_id FROM common_small_agreement WHERE game_id = '$this->gameId'";
			array_push($sqlArray, $sql);
				
			$results = $this->dataBaseController->getterArray($sqlArray);
			
			if (!$results) {
				$this->responseCreator->setError('waitingConnection error');
				return $this->responseCreator->getData();
			}
			
			$this->responseCreator->setData('fishka_positions', $results[0]);			
			$this->responseCreator->setData('is_game_begun', $results[1][0]['is_game_begun']);			
			$this->responseCreator->setData('common_small_agreement_id_list', array_map(
				function($item){
					return $item['small_agreement_id'];
				}, $results[2]
			));
			
			// Get common_events data_(start)
			$sqlArray = [];			
			
			$sql = "SELECT * FROM game_info WHERE id = '$this->gameId'";
			array_push($sqlArray, $sql);
			
			$sql = "SELECT * FROM common_events WHERE game_id = '$this->gameId'";
			array_push($sqlArray, $sql);
			
			$results = $this->dataBaseController->getterArray($sqlArray);
			
			$date = new DateTimeImmutable();
			$timeStamp = $date->getTimestamp();
			
			if (!$results) {
				$this->responseCreator->setData('common_events', [
					'gamer_id_turn' => '0',
					'market_id' => '-1',
					'time_stamp' => $timeStamp
				]);
			} else {
				$this->responseCreator->setData('common_events', [
					'gamer_id_turn' => $results[0][0]['gamer_id_turn'],
					'market_id' => $results[1][0]['market_id'],
					'time_stamp' => $timeStamp
				]);
			}
			// Get common_events data_(end)
			
			return $this->responseCreator->getData();
		}
		
		public function set($marketId) {
			$sql = "SELECT * FROM common_events WHERE game_id = '$this->gameId'";
			$isPresent = $this->dataBaseController->checkDataPresent($sql);
			
			if (!$isPresent) {
				$sql = "INSERT INTO common_events (game_id, market_id, number) VALUES ($this->gameId, $marketId, 0)";
			} else {
				$sql = "UPDATE common_events SET market_id = '$marketId' WHERE game_id = '$this->gameId'";
			}			
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('common_events save error');
				return $this->responseCreator->getData();
			}
			
			$this->responseCreator->setData('common_events saved', 'success');
			return $this->responseCreator->getData();
		}
	}
?>