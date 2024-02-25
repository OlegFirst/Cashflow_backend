<?php
	class RNDCreator {		
		private static function generateRND($maxValue, $arrayListLength) {
			$value = rand(0, $maxValue);
			return $value < $arrayListLength ? $value : 0;
		}
		
		public static function proceed($arrayLength) {
			$arrayList = [];
			$arrayRNDList = [];
			
			for ($index = 0; $index <= $arrayLength; $index++) {
				array_push($arrayList, $index);
			}
			
			$arrayListLength = count($arrayList);
			
			while (count($arrayRNDList) < $arrayListLength - 1) {
				$rndIndex = RNDCreator::generateRND($arrayListLength -1, $arrayListLength);
				$rndValue = $arrayList[$rndIndex];
				
				if (!$rndValue) {
					for ($index = 0; $index < $arrayListLength; $index++) {
						if ($arrayList[$index]) {
							array_push($arrayRNDList, $arrayList[$index]);
							$arrayList[$index] = null;
							break;
						}
					}
				} else {
					array_push($arrayRNDList, $rndValue);
					$arrayList[$rndIndex] = null;
				}
			}
			
			return $arrayRNDList;
		}
	}
?>