<?php
	include './classes/Game.php';
	include './classes/GameOwner.php';
	include './classes/GameGamer.php';

	class GameConctructor {		
		public static function createInstance($data) {
			$obj = json_decode($data['data']);
			
			if ($obj->userRoleId === 3) {
				return new GameGamer($data);
			}
			
			return new GameOwner($data);
		}
	}
?>