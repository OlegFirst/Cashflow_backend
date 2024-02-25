<?php
	function gameRouter() {
		$queryElements = parseQuery();		
		$route = array(
			'body' => null,
			'data' => null
		);
		
		if (
			array_key_exists('info', $queryElements) &&
			array_key_exists('data', $queryElements)
		) {			
			$route['body'] = $queryElements['info'];
			$route['data']['data'] = $queryElements['data'];
		}
		
		return $route;
	}
?>