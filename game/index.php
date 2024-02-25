<?php
	// Game
	
	include '../config.php';
	include '../classes/DataBaseController.php';
	include '../classes/Enums.php';
	include './game-router.php';
	include './classes/GameConstructor.php';
	include '../cards/professions/Professions.php';
	include '../classes/Schema.php';
	include '../classes/ResponseCreator.php';
	include '../classes/RNDCreator.php';
	include './classes/user-model/UserModel.php';
	include './classes/user-model/UserModelConstructor.php';
	include '../cards/CardConstructor.php';
	include './classes/user-model/sql-creators/Insert.php';
	include './classes/game-instance/GameSingelton.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$route = gameRouter();
	
	// Create GameOwner or GameGamer instance
	$game = GameConctructor::createInstance($route['data']);
	
	$results = null;
	
	switch ($route['body']) {
		case GameQueryElements::GAME_PREPARATION:
			$results = $game->preparation();
			break;
		
		// Game turn_(start)
		case GameQueryElements::GAME_OWNER_CHECK_MAKE_NEXT_TURN:
			$results = $game->checkMakeNextTurn();
			break;
		
		case GameQueryElements::GAME_OWNER_MAKE_NEXT_TURN:
			$results = $game->makeNextTurn();
			break;
			
		case GameQueryElements::GAMER_START_TURN:
			$results = $game->gamerStartTurn();
			break;
			
		case GameQueryElements::GAMER_END_TURN:
			$results = $game->gamerEndTurn();
			break;
		// Game turn_(end)
		
		// Model user_(start)
		case GameQueryElements::GAME_USER_MODEL_UPDATE:
			$results = $game->userModelUpdate($route['data']);
			break;
			
		case GameQueryElements::GAME_USER_MODEL_REMOVE:
			$results = $game->userModelRemove($route['data']);
			break;
		
		case GameQueryElements::GAME_USER_MODEL_INSERT:
			$results = $game->userModelInsert($route['data']);
			break;
		// Model user_(end)
		
		// Waiting connection
		case GameQueryElements::WAITING_CONNECTION:
			$results = $game->waitingConnection();
			break;
			
		// Fishka
		case GameQueryElements::SET_FISHKA_POSITION:
			$results = $game->setFishkaPosition($route['data']);
			break;
		
		// Agreement card_(start)
		case GameQueryElements::GAME_OWNER_SEND_AGREEMENT_TO_GAMER:
			$results = $game->sendAgreementToGamer($route['data']);
			break;
			
		case GameQueryElements::GAME_OWNER_SEND_COMMON_AGREEMENT_TO_GAMER:
			$results = $game->sendCommonAgreementToGamer($route['data']);
			break;
			
		case GameQueryElements::GAME_OWNER_REMOVE_AGREEMENT_FROM_GAMER:
			$results = $game->removeAgreementFromGamer($route['data']);
			break;
			
		case GameQueryElements::GAMER_GET_AGREEMENT:
			$results = $game->gamerGetAgreement($route['data']);
			break;
			
		case GameQueryElements::GAMER_REMOVE_AGREEMENT:
			$results = $game->gamerRemoveAgreement($route['data']);
			break;
			
		case GameQueryElements::GAMER_SELL_AGREEMENT:
			$results = $game->gamerSellAgreement($route['data']);
			break;
			
		case GameQueryElements::GAMER_BUY_AGREEMENT:
			$results = $game->gamerBuyAgreement($route['data']);
			break;
		// Agreement card_(end)
		
		// Get market card
		case GameQueryElements::GAME_OWNER_GET_MARKET:
			$results = $game->getMarket();
			break;
			
		// Get MONEY_IN_THE_WIND card
		case GameQueryElements::GAME_OWNER_GET_MONEY_IN_THE_WIND:
			$results = $game->getMoneyInTheWind();
			break;
			
		// Set CharityTurnsLeft
		case GameQueryElements::GAME_OWNER_SET_CHARITY_TURNS_LEFT:
			$results = $game->setCharityTurnsLeft($route['data']);
			break;
			
		// Move Gamer to another path
		case GameQueryElements::GAME_OWNER_MOVE_GAMER_TO_PATH:
			$results = $game->moveGamerToPath($route['data']);
			break;
			
		// Dream_(start)
		case GameQueryElements::GAMER_GET_DREAM:
			$results = $game->getDream($route['data']);
			break;
		
		case GameQueryElements::GAMER_SET_DREAM:
			$results = $game->setDream($route['data']);
			break;
		// Dream_(end)
			
		default:
			echo 'Bad game request';
	}
	
	if ($results && $results['isSuccess']) {
		echo json_encode($results['data']);
		return;
	}
	
	header("HTTP/1.1 500 Failed");	
	echo json_encode($results['errorMesage']);
?>