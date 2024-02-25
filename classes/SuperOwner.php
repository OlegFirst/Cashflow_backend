<?php	
	include 'Owner.php';

	class SuperOwner extends Owner {		
		public function getGameOwnersData() {
			$userRoleId = 2;
			$ownerData = [];
			
			// Get game owners
			$sql = "SELECT id, name, login, password FROM users WHERE user_role_id = '$userRoleId'";
			$owners = $this->dataBaseController->getter($sql);
			if (!$owners) {
				return [];
			}
			
			// Get games and game rent belong to each owner
			foreach ($owners as $owner) {
				$ownerId = $owner['id'];
				
				$sql = "SELECT * FROM game_info WHERE owner_id = '$ownerId'";
				$games = $this->dataBaseController->getter($sql);
				if (!$games) {
					$games = [];
				}
				
				$data = new Schema();
				$data->setData('owner', $owner);
				$data->setData('games', $games);
				
				$sql = "SELECT starting_rent_date, ending_rent_date FROM game_rent WHERE owner_id = '$ownerId'";
				$results = $this->dataBaseController->getter($sql);
				if (!$results) {
					$results = [];
				}
				
				$data->setData('game_rent', $results[0]);
				array_push($ownerData, $data->getData());
			}
			
			return $ownerData;
		}
		
		public function createNewGameOwner($data) {
			$obj = json_decode($data['data']);
			$name = trim($obj->name);			
			$userRoleId = 2;
			
			// Check if this game owner has already present
			$sql = "SELECT name from users WHERE user_role_id = '$userRoleId'";
			$results = $this->dataBaseController->getter($sql);			
			$isNamePresent = false;
			if ($results) {
				foreach ($results as $item) {
					if (strtolower($item['name']) === strtolower($name)) {
						$isNamePresent = true;
					}
			 }
			}			
			if ($isNamePresent) {
				$this->responseCreator->setError('isNamePresent error');
				return $this->responseCreator->getData();
			}
			
			// Create new game owner
			$sql = "INSERT INTO users (name, login, password, user_role_id, game_id)
							VALUES
							('$name', '$obj->login', '$obj->password', '$userRoleId', '0')";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('Create new game owner error');
				return $this->responseCreator->getData();
			}
			
			// Get created game owner`s Id
			$sql = "SELECT id from users WHERE user_role_id = '$userRoleId' AND name='$name' ";
			$results = $this->dataBaseController->getter($sql);
			if (!$results) {
				$this->responseCreator->setError('Get created Id error');
				return $this->responseCreator->getData();
			}
			$id = $results[0]['id'];
			
			// Create renting info
			$sql = "INSERT INTO game_rent (owner_id, starting_rent_date, ending_rent_date)
							VALUES
							('$id', '$obj->startingRentDate', '$obj->endingRentDate')";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('Create new game owner error');
				return $this->responseCreator->getData();
			}
			
			return true;
		}
		
		public function removeGameOwner($data) {
			$ownerId = $data['owner_id'];
			
			// Check if at least one of the current owner game is in progress or prepared
			$sql = "SELECT is_game_begun, is_game_prepared FROM game_info WHERE owner_id = '$ownerId'";
			$results = $this->dataBaseController->getter($sql);
			
			if ($results) {
				$isSuccess = false;
				
				foreach($results as $item) {
					if ($item['is_game_begun']) {
						$isSuccess = true;
					}
					
					if ($item['is_game_prepared']) {
						$isSuccess = true;
					}
				}
				
				if ($isSuccess) {
					$this->responseCreator->setError('Неможливо видалити. Триває принаймні одна гра.');
					return $this->responseCreator->getData();
				}
			}			
			
			// Remove all games belong to the current game owner
			$sql = "DELETE FROM game_info WHERE owner_id = '$ownerId'";
			$this->dataBaseController->setter($sql);
			
			// Remove the current game owner
			$sql = "DELETE FROM users WHERE id = '$ownerId' AND user_role_id = '2'";
			$isSuccess = $this->dataBaseController->setter($sql);
			if (!$isSuccess) {
				$this->responseCreator->setError('Delete game owner error');
				return $this->responseCreator->getData();
			}
			
			// Success
			return $this->responseCreator->getData();
		}
	}
?>