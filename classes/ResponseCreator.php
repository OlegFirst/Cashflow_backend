<?php
	class ResponseCreator {
		private $response = array(
			'isSuccess' => true,
			'data' => null,
			'errorMesage' => ''
		);
		private $schema = null;
		
		public function __construct() {
			$this->response['isSuccess'] = true;
			$this->schema = new Schema();
		}
		
		public function getData() {
			$this->response['data'] = $this->schema->getData();
			return $this->response;
		}
		
		public function setError($errorMesage = '') {
			$this->response['isSuccess'] = false;
			$this->response['errorMesage'] = $errorMesage;
		}
		
		public function setData($key, $value) {
			$this->schema->setData($key, $value);
		}
		
		public function clearData() {
			$this->response['isSuccess'] = false;
			$this->response['data'] = null;
			$this->response['errorMesage'] = '';
			$this->schema->clearData();
		}
	}
?>