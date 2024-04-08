<?php
	$dataBaseController = null;
	$responseCreator = null;

	class Utils {
		public function __construct($dataBaseController, $responseCreator) {
			$this->dataBaseController = $dataBaseController;
			$this->responseCreator = $responseCreator;
		}

		public function getGamerTurnInformation($gamerId, $isMakeNextTurn = false) {
			$gamerTurnData = new Schema();
			
			// Get cash
			$sql = "SELECT result FROM user_model_arithmetic WHERE gamer_id = '$gamerId' AND property = 'cash'";
			$isCashPresent = $this->dataBaseController->checkDataPresent($sql);			
			if (!$isCashPresent) {
				$gamerTurnData->setData('cash', 0);
			} else {
				$results = $this->dataBaseController->getter($sql);
				if (!$results) {
					$this->responseCreator->setError('Get cash error');
					return $this->responseCreator->getData();
				}
				$gamerTurnData->setData('cash',  end($results)['result']);
			}
			
			// Check bankupt situation
			$sql = "SELECT result FROM user_model_arithmetic WHERE gamer_id = '$gamerId' AND property = 'money_flow'";
			$isMoneyFlowPresent = $this->dataBaseController->checkDataPresent($sql);
			
			if (!$isMoneyFlowPresent) {
				$gamerTurnData->setData('is_bankrupt_value_present', false);
			} else {
				$results = $this->dataBaseController->getter($sql);
				if (!$results) {
					$this->responseCreator->setError('Get moneyFlow error');
					return $this->responseCreator->getData();
				}
				
				$moneyFlow = end($results)['result'];
				$gamerTurnData->setData('is_bankrupt_value_present',  end($results)['result'] < GameCases::BANKRUPT_CASH_FLOW_VALUE);
			}
			
			// Get incomes_real_estate
			$sql = "SELECT incomes_real_estate FROM user_model_total WHERE gamer_id = '$gamerId'";
			$results = $this->dataBaseController->getter($sql);			
			if (!$results) {
				$this->responseCreator->setError('get incomes_real_estate error');
				return $this->responseCreator->getData();
			}
			$gamerTurnData->setData('incomes_real_estate', $results[0]['incomes_real_estate']);
			
			// Get charity_turns_left & path size
			$sql = "SELECT is_small_path, charity_turns_left FROM user_model WHERE gamer_id='$gamerId'";
			$results = $this->dataBaseController->getter($sql);		
			if (!$results) {
				$this->responseCreator->setError('charity_turns_left error');
				return $this->responseCreator->getData();
			}
			$isSmallPath = $results[0]['is_small_path'];
			$charityTurnsLeft =  $results[0]['charity_turns_left'];
			
			// - If function is called from makeNextTurn()
			if ($isMakeNextTurn) {
				$charityTurnsLeft = $this->charityTurnsLeftDecrement($gamerId, $isSmallPath, $charityTurnsLeft);
			}
			
			$gamerTurnData->setData('is_small_path', $isSmallPath);
			$gamerTurnData->setData('charity_turns_left', $charityTurnsLeft);
			
			// Create response
			$this->responseCreator->setData('gamer_turn_data', $gamerTurnData->getData());
		}
		
		private function charityTurnsLeftDecrement($gamerId, $isSmallPath, $charityTurnsLeft) {
			$currentCharityTurnsLeft = $charityTurnsLeft;
			
			if ($charityTurnsLeft > 0) {
				if ($isSmallPath) {
					$currentCharityTurnsLeft = $charityTurnsLeft - 1;
					
					$sql = "UPDATE user_model SET charity_turns_left = '$currentCharityTurnsLeft' WHERE gamer_id = '$gamerId'";
					$isSuccess = $this->dataBaseController->setter($sql);		
					if (!$isSuccess) {
						$this->responseCreator->setError('charity_turns_left decrement error');
						return $this->responseCreator->getData();
					}
				}
			}
			
			return $currentCharityTurnsLeft;
		}
	}
?>