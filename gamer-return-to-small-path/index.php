<?php
	// Gamer retutn to small path. 
	//
	// Behavior: The same as Bankrupt, but Cash is kept
	
	include '../config.php';
	include './router.php';
	include '../classes/DataBaseController.php';
	include '../classes/Enums.php';
	include '../classes/Schema.php';
	include '../classes/ResponseCreator.php';		
	include '../gamer-bankrupt/classes/GamerBankrupt.php';
	include '../cards/professions/Professions.php';
	include '../classes/RNDCreator.php';
	include '../cards/CardConstructor.php';
	include './classes/GamerReturnToSmallPath.php';
	include '../game/classes/user-model/UserModel.php';
	include '../game/classes/user-model/UserModelConstructor.php';
	include '../classes/DataBaseTablesClear.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$route = router();
	$results = null;
	
	$gamerReturnToSmallPath = new GamerReturnToSmallPath($route['data']);
	$gamerReturnToSmallPath->storeCash();	
	$results = $gamerReturnToSmallPath->proceed();
	$gamerReturnToSmallPath->saveCash();
	
	if ($results && $results['isSuccess']) {
		echo json_encode($results['data']);
		return;
	}
	
	header("HTTP/1.1 500 Failed");	
	echo json_encode($results['errorMesage']);
?>