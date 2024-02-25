<?php
	// Gamer bankrupt
	
	include '../config.php';
	include './router.php';
	include '../classes/DataBaseController.php';
	include '../classes/Enums.php';
	include '../classes/Schema.php';
	include '../classes/ResponseCreator.php';
	include './classes/GamerBankrupt.php';
	include '../cards/professions/Professions.php';
	include '../classes/RNDCreator.php';
	include '../cards/CardConstructor.php';
	include '../game/classes/user-model/UserModel.php';
	include '../game/classes/user-model/UserModelConstructor.php';
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		header("HTTP/1.1 400 Bad request method");
		return;
	}
	
	$route = gameRouter();
	$results = null;
	
	$gamerBankrupt = new GamerBankrupt($route['data']);
	$results = $gamerBankrupt->procced();
	
	if ($results && $results['isSuccess']) {
		echo json_encode($results['data']);
		return;
	}
	
	header("HTTP/1.1 500 Failed");	
	echo json_encode($results['errorMesage']);
?>