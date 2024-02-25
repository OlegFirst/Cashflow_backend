<?php
	include '../get-messages/Messages.php';

	class GameProcessing {
		private $userId = null;
		private $gameId = null;
		private	$mode = null;
		private $dataBaseController = null;
		
		function __construct($data) {
			$obj = json_decode($data['data']);
			
			$this->userId = $obj->user_id;
			$this->gameId = $obj->game_id;
			$this->mode = $obj->mode;
			
			$this->dataBaseController = new DataBaseController();
		}
		
		function gameProcessingInitialisation() {
			switch ($this->mode) {
				case GameProcessingModes::START:
					return $this->gameStart();
					break;
					
				case GameProcessingModes::CANCEL:
					return $this->gameCancel();
					break;
					
				case GameProcessingModes::COMPLETE:
					return $this->gameComplete();
					break;
					
				default:
					header("HTTP/1.1 400 Bad request method");
					echo 'Bad game request';
					return;
			}
		}
		
		function gameStart() {
			// - Check if the other game has been already started by current user
			$sql = "SELECT * FROM game_info WHERE owner_id = '$this->userId' AND is_game_begun = 1";			
			$result = $this->dataBaseController->getter($sql) ?? [];
			
			if (count($result) > 0) {
				return false;
			}
			
			// - Update the game_info table
			$sql = "UPDATE game_info SET is_game_begun = " . GameProcessingModes::START . " WHERE id = '$this->gameId'";			
			$isSuccess = $this->dataBaseController->setter($sql);
			
			if (!$isSuccess) {
				return false;
			}
			
			return $this->sendMessage('game_start');
		}
		
		function gameCancel() {
			// - Update the game_info table
			$sql = "UPDATE game_info SET is_game_begun = " . GameProcessingModes::CANCEL . " WHERE id = '$this->gameId'";			
			$isSuccess = $this->dataBaseController->setter($sql);
			
			if (!$isSuccess) {
				return false;
			}
			
			return $this->sendMessage('game_cancel');
		}
		
		function gameComplete() {
			// - Update the game_info table
			$sql = "UPDATE game_info SET is_game_begun = " . GameProcessingModes::COMPLETE . " WHERE id = '$this->gameId'";			
			$isSuccess = $this->dataBaseController->setter($sql);
			
			if (!$isSuccess) {
				return false;
			}
			
			return $this->sendMessage('game_complete');
		}
		
		// Send message to the Message class
		function sendMessage($message) {
			$messages = new Messages($this->userId, $this->gameId);
			return $messages->setMessage($message);
		}
	}
?>