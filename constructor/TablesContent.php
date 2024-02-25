<?php
	class TablesContent {
		protected $dataBaseController = null;
		protected $responseCreator = null;
		
		public function __construct() {			
			$this->dataBaseController = new DataBaseController();
			$this->responseCreator = new ResponseCreator();
		}
		
		public function proceed() {
			// users
			$sql = "CREATE TABLE users (
				id int(255) AUTO_INCREMENT PRIMARY KEY,
				name varchar(40),
				loging varchar(40),
				password varchar(40),
				user_role_id int(10),
				game_id int(255)
			)";
			$this->sqlSetter($sql, 'users');
			
			// // game_info
			// $sql = "CREATE TABLE game_info (
				// id int(255) DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
				// name varchar(40),
				// user_role_id int(255),
				// game_id int(255),
				// date int(255),
				// time int(255),
				// is_game_begun tinyint(1)			
			// )";
			// $this->sqlSetter($sql, 'game_info');
			
			// users
			// $sql = "CREATE TABLE users (
				// id int(255) AUTO_INCREMENT PRIMARY KEY,
				// name varchar(40),
				// loging varchar(40),
				// password varchar(40),
				// user_role_id int(255),
				// game_id int(255)
			// )";
			// $this->sqlSetter($sql, 'users');
			
			return $this->responseCreator->getData();
		}
		
		private function sqlSetter($sql, $tableName) {
			$isSuccess = $this->dataBaseController->setter($sql);			
			if (!$isSuccess) {
				$this->responseCreator->setError('Create $tableName error');
				return $this->responseCreator->getData();
			}
		}
	}
?>