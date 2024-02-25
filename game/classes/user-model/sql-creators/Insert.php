<?php
	class Insert {		
		public static function sqlCreatorInsertValueList($gamerId, $gameId, $obj, $item) {			
			switch ($obj->type) {
				case ProfessionCardTypes::ACTIONS:
					return "INSERT INTO user_model_actions (gamer_id, game_id, name, count, price, cost, income) VALUES 
								('$gamerId', '$gameId', '$item->name', '$item->count', '$item->price', '$item->cost', '$item->income')";
								
				case ProfessionCardTypes::REAL_ESTATE:
					return "INSERT INTO user_model_real_estate (gamer_id, game_id, name, deposit, price, bail, income) VALUES 
								('$gamerId', '$gameId', '$item->name', '$item->deposit', '$item->price', '$item->bail', '$item->income')";
								
				case ProfessionCardTypes::BUSINESS:
					return "INSERT INTO user_model_business (gamer_id, game_id, name, deposit, price, bail, income) VALUES 
								('$gamerId', '$gameId', '$item->name', '$item->deposit', '$item->price', '$item->bail', '$item->income')";
								
				case ProfessionCardTypes::ARITHMETIC:
					$property= $obj->objKey->property;
					$subProperty= $obj->objKey->sub_property;					
					return "INSERT INTO user_model_arithmetic (gamer_id, game_id, property, sub_property, value, result) VALUES 
								('$gamerId', '$gameId', '$property', '$subProperty', '$item->value', '$item->result')";
								
				case ProfessionCardTypes::BUYED_DREAMS:
					return "INSERT INTO user_model_buyed_dreams (gamer_id, game_id, name, price) VALUES 
								('$gamerId', '$gameId', '$item->name', '$item->price')";
								
				case ProfessionCardTypes::BUYED_BUSINESS:
					return "INSERT INTO user_model_buyed_business (gamer_id, game_id, name, passive_incomes, money_flow) VALUES 
								('$gamerId', '$gameId', '$item->name', '$item->passiveIncomes', '$item->moneyFlow')";
								
				case ProfessionCardTypes::BUYED_CASH:
					return "INSERT INTO user_model_buyed_cash (gamer_id, game_id, value, result) VALUES 
								('$gamerId', '$gameId', '$item->value', '$item->result')";
					
				default:
					return null;
			}
		}
		
		public static function sqlCreatorUpdateValueList($gamerId, $type, $item) {
			switch ($type) {
				case ProfessionCardTypes::ACTIONS:
					return "UPDATE user_model_actions 
						SET name = '$item->name', count = '$item->count', price = '$item->price', cost = '$item->cost', income = '$item->income'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
						
				case ProfessionCardTypes::REAL_ESTATE:
					return "UPDATE user_model_real_estate 
						SET name = '$item->name', deposit = '$item->deposit', price = '$item->price', bail = '$item->bail', income = '$item->income'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
						
				case ProfessionCardTypes::BUSINESS:
					return "UPDATE user_model_business
						SET name = '$item->name', deposit = '$item->deposit', price = '$item->price', bail = '$item->bail', income = '$item->income'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
						
				case ProfessionCardTypes::ARITHMETIC:
					return "UPDATE user_model_arithmetic
						SET value = '$item->value', result = '$item->result'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
						
				case ProfessionCardTypes::BUYED_DREAMS:
					return "UPDATE user_model_buyed_dreams
						SET name = '$item->name', price = '$item->price'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
				
				case ProfessionCardTypes::BUYED_BUSINESS:
					return "UPDATE user_model_buyed_business 
						SET name = '$item->name', passive_incomes = '$item->passiveIncomes', money_flow = '$item->moneyFlow'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
						
				case ProfessionCardTypes::BUYED_CASH:
					return "UPDATE user_model_buyed_cash
						SET value = '$item->value', result = '$item->result'
						WHERE gamer_id = '$gamerId' AND id = '$item->id'";
				
				default:
					return null;
			}
		}
		
		public static function sqlCreatorUpdateTotal($gamerId, $type, $total) {
			switch ($type) {			
				case ProfessionCardTypes::ACTIONS:
					return "UPDATE user_model_total SET incomes_actions = '$total' WHERE gamer_id = '$gamerId'";
					
				case ProfessionCardTypes::REAL_ESTATE:
					return "UPDATE user_model_total SET incomes_real_estate = '$total' WHERE gamer_id = '$gamerId'";
					
				case ProfessionCardTypes::BUSINESS:
					return "UPDATE user_model_total SET incomes_business = '$total' WHERE gamer_id = '$gamerId'";
					
				default:
					return null;
			}
		}
		
		public static function sqlCreatorRemoveValueList($gamerId, $type, $item) {
			switch ($type) {			
				case ProfessionCardTypes::ACTIONS:
					return "DELETE FROM user_model_actions WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::REAL_ESTATE:
					return "DELETE FROM user_model_real_estate WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::BUSINESS:
					return "DELETE FROM user_model_business WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::ARITHMETIC:
					return "DELETE FROM user_model_arithmetic WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::BUYED_DREAMS:
					return "DELETE FROM user_model_buyed_dreams WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::BUYED_BUSINESS:
					return "DELETE FROM user_model_buyed_business WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				case ProfessionCardTypes::BUYED_CASH:
					return "DELETE FROM user_model_buyed_cash WHERE gamer_id='$gamerId' AND id = '$item->id'";
					
				default:
					return null;
			}
		}
	}
?>