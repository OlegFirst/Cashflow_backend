<?php
	class CardConstructor {
		private $smallAgreementCount = 66;
		private $bigAgreementCount = 40;
		private $marketCount = 44;
		private $moneyInTheWindCount = 40;
		
		private $gameId = null;
		private $dataBaseController = null;
		
		public function __construct($gameId, $dataBaseController) {
			$this->gameId = $gameId;
			$this->dataBaseController = $dataBaseController;
		}
		
		public function createRNDCardLists($gameId, $type) {
			$this->gameId = $gameId;			
			$sqlArray = [];
			
			if ($type === CardTypes::SMALL_AGREEMENT || $type === CardTypes::ALL_TYPES) {
				$currentType = CardTypes::SMALL_AGREEMENT;
				$indexRNDList = RNDCreator::proceed($this->smallAgreementCount - 1);
				foreach ($indexRNDList as $index) {
					$cardId = $index + 1;
					$sql = "INSERT INTO cards (game_id, card_id, type) VALUES ('$this->gameId', '$cardId', '$currentType')";
					array_push($sqlArray, $sql);
				}
			}
			
			if ($type === CardTypes::BIG_AGREEMENT || $type === CardTypes::ALL_TYPES) {
				$currentType = CardTypes::BIG_AGREEMENT;
				$indexRNDList = RNDCreator::proceed($this->bigAgreementCount - 1);
				foreach ($indexRNDList as $index) {
					$cardId = $index + 1;
					$sql = "INSERT INTO cards (game_id, card_id, type) VALUES ('$this->gameId', '$cardId', '$currentType')";
					array_push($sqlArray, $sql);
				}
			}
			
			if ($type === CardTypes::MARKET || $type === CardTypes::ALL_TYPES) {
				$currentType = CardTypes::MARKET;
				$indexRNDList = RNDCreator::proceed($this->marketCount - 1);
				foreach ($indexRNDList as $index) {
					$cardId = $index + 1;
					$sql = "INSERT INTO cards (game_id, card_id, type) VALUES ('$this->gameId', '$cardId', '$currentType')";
					array_push($sqlArray, $sql);
				}
			}
			
			if ($type === CardTypes::MONEY_IN_THE_WIND || $type === CardTypes::ALL_TYPES) {
				$currentType = CardTypes::MONEY_IN_THE_WIND;
				$indexRNDList = RNDCreator::proceed($this->moneyInTheWindCount - 1);
				foreach ($indexRNDList as $index) {
					$cardId = $index + 1;
					$sql = "INSERT INTO cards (game_id, card_id, type) VALUES ('$this->gameId', '$cardId', '$currentType')";
					array_push($sqlArray, $sql);
				}
			}
				
			$result = $this->dataBaseController->setterArray($sqlArray);
			
			if (!$result) {
				return false;
			}
			
			return true;
		}
	}
?>