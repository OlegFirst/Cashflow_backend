<?php
	function superOwnerRouter($queryElements) {
		$route = array(
			'body' => '',
			'data' => array()
		);
		
		if (
			array_key_exists(QueryElements::LOGIN, $queryElements) &&
			array_key_exists(QueryElements::PASSWORD, $queryElements) &&
			count($queryElements) === 2
		) {
			$route['body'] = 'GET_SUPER_USER_DATA';			
			$route['data'][QueryElements::LOGIN] = $queryElements[QueryElements::LOGIN];
			$route['data'][QueryElements::PASSWORD] = $queryElements[QueryElements::PASSWORD];
		}
		
		// CREATE_NEW_GAME
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('data', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::CREATE_NEW_GAME) {
				$route['body'] = QueryElements::CREATE_NEW_GAME;
				$route['data']['data'] = $queryElements['data'];
			}
		}
		
		// EDIT_GAME
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('data', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::EDIT_GAME) {
				$route['body'] = QueryElements::EDIT_GAME;
				$route['data']['data'] = $queryElements['data'];
			}
		}
		
		// GET_GAMES
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('user_id', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::GET_GAMES) {
				$route['body'] = QueryElements::GET_GAMES;
				$route['data']['user_id'] = $queryElements['user_id'];
			}
		}
		
		// CREATE_NEW_GAME_OWNER 
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('data', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::CREATE_NEW_GAME_OWNER) {
				$route['body'] = QueryElements::CREATE_NEW_GAME_OWNER;
				$route['data']['data'] = $queryElements['data'];
			}
		}
		
		// REMOVE_GAME_OWNER 
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('owner_id', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::REMOVE_GAME_OWNER) {
				$route['body'] = QueryElements::REMOVE_GAME_OWNER;
				$route['data']['owner_id'] = $queryElements['owner_id'];
			}
		}
		
		// REMOVE_GAME
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('game_id', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::REMOVE_GAME) {
				$route['body'] = QueryElements::REMOVE_GAME;
				$route['data']['game_id'] = $queryElements['game_id'];
			}
		}
		
		// GAME_PROCESSING
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('data', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::GAME_PROCESSING) {
				$route['body'] = QueryElements::GAME_PROCESSING;
				$route['data']['data'] = $queryElements['data'];
			}
		}
		
		// GET_GAME_OWNERS_DATA
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('user_id', $queryElements)
		) {
			if ($queryElements['info'] === QueryElements::GET_GAME_OWNERS_DATA) {
				$route['body'] = QueryElements::GET_GAME_OWNERS_DATA;
				$route['data']['user_id'] = $queryElements['user_id'];
			}
		}
		
		return $route;
	}
?>