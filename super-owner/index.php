<?php
	// Super owner
	
	include '../config.php';
	include '../classes/DataBaseController.php';
	include '../classes/SuperOwner.php';
	include './GameProcessing.php';
	include '../classes/Enums.php';
	include 'SuperOwnerRouter.php';
	
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$queryElements = parseQuery();
	$superOwner = new SuperOwner($queryElements);	
	$route = superOwnerRouter($queryElements);
	
	$results = null;
	
	switch ($route['body']) {
		// Get super owner data
		case QueryElements::GET_USER_DATA:
			$results = $superOwner->getOwnerData();
			break;
			
		// Create new game
		case QueryElements::CREATE_NEW_GAME:		
			$isSuccess = $superOwner->createNewGame($route['data']);
			$results = createResultsStatus($isSuccess);
			break;
			
		// Create new game
		case QueryElements::EDIT_GAME:		
			$isSuccess = $superOwner->editGame($route['data']);
			if (!$isSuccess) {
				header("HTTP/1.1 500 Failed");
			}
			$results = $isSuccess === true ? 'Success' : 'Failed';
			break;
			
		// Get list of created games
		case QueryElements::GET_GAMES:
			$results = $superOwner->getGames($route['data']);
			break;
			
		// Remove game owner
		case QueryElements::REMOVE_GAME_OWNER:
			$results = $superOwner->removeGameOwner($route['data']);			
			if (!$results['isSuccess']) {
				header("HTTP/1.1 500 Failed");
			}
			break;
		
		// Remove game
		case QueryElements::REMOVE_GAME:
			$isSuccess = $superOwner->removeGame($route['data']);
			if (!$isSuccess) {
				header("HTTP/1.1 500 Failed");
			}
			$results = $isSuccess === true ? 'Success' : 'Failed';
			break;
			
		// Game processing
		case QueryElements::GAME_PROCESSING:
			$gameProcessing = new GameProcessing($route['data']);
			$isSuccess = $gameProcessing->gameProcessingInitialisation();
			if (!$isSuccess) {
				header("HTTP/1.1 500 Failed");
			}
			$results = $isSuccess === true ? 'Success' : 'Failed';
			break;
			
		// Get game owners data
		case QueryElements::GET_GAME_OWNERS_DATA:
			$results = $superOwner->getGameOwnersData();						
			if ($results === false) {
				header("HTTP/1.1 500 Failed");
			}			
			$results = $results ?? 'Failed';
			break;
			
		// Create new game owner
		case QueryElements::CREATE_NEW_GAME_OWNER:
			$results = $superOwner->createNewGameOwner($route['data']);
			
			
			// if ($results === false) {
				// header("HTTP/1.1 500 Failed");
			// }			
			// $results = $results ?? 'Failed';
			break;
			
		default:
			header("HTTP/1.1 400 Bad request method");
			echo 'Bad game request';
			return;
	}
	
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	header("Access-Control-Allow-Hedares: X-Request-With");
	
	echo json_encode($results);
?>