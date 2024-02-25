<?php
	class Schema {
		private $matrix = [];
		
		public function setData($key, $value) {
			$this->matrix[$key] = $value;
		}
		
		public function getData() {
			return $this->matrix;
		}
		
		public function clearData() {
			$matrix = [];
		}
	}
?>