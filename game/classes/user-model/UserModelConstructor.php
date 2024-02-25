<?php
	class UserModelConstructor {
		public static function create($gamerId, $gameId, $profession, $color, $dataBaseController) {	
			// user_model
			$sql = "INSERT INTO user_model (gamer_id, game_id, profession_name, profession_id, is_small_path, path_position_id, path_position_left, path_position_top, color, charity_turns_left)
				VALUES ('$gamerId', '$gameId', '" . $profession['professionName'] . "', '" . $profession['id'] . "', '1', '0', '-130px', '725px', '$color', '0')";
				
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// incomes_(start)
			$sql = "INSERT INTO user_model_incomes_const (gamer_id, game_id, salary)
				VALUES ('$gamerId', '$gameId', '" . $profession['incomes']['salary'] . "')";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// expenses
			$v1 = $profession['expenses']['taxes'];
			$v2 = $profession['expenses']['percentagesExpensesOfMortage'];
			$v3 = $profession['expenses']['expensesByEducationPosition'];
			$v4 = $profession['expenses']['carExpenses'];
			$v5 = $profession['expenses']['creditCardsExpenses'];
			$v6 = $profession['expenses']['retailPurchasesExpenses'];
			$v7 = $profession['expenses']['otherExpenses'];
			$sql = "INSERT INTO user_model_expenses_const (
				gamer_id, game_id, taxes, percentagesExpensesOfMortage, expensesByEducationPosition, carExpenses,
				creditCardsExpenses, retailPurchasesExpenses, otherExpenses 
				) VALUES ( '$gamerId', '$gameId', '$v1', '$v2', '$v3', '$v4', '$v5', '$v6', '$v7' )";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// assets
			$sql = "INSERT INTO user_model_assets_const (gamer_id, game_id, savings)
				VALUES ('$gamerId', '$gameId', '" . $profession['assets']['savings'] . "')";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// creditLiabilities
			$v1 = $profession['creditLiabilities']['mortage'];
			$v2 = $profession['creditLiabilities']['educationLoan'];
			$v3 = $profession['creditLiabilities']['carLoan'];
			$v4 = $profession['creditLiabilities']['creditCards'];
			$v5 = $profession['creditLiabilities']['debtForRetailPurchases'];
			
			$sql = "INSERT INTO user_model_credit_liabilities_const (
				gamer_id, game_id, mortage, educationLoan, carLoan, creditCards, debtForRetailPurchases
				) VALUES ( '$gamerId', '$gameId', '$v1', '$v2', '$v3', '$v4', '$v5' )";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// childExpenses
			$sql = "INSERT INTO user_model_child_expenses_const (gamer_id, game_id, value)
				VALUES ('$gamerId', '$gameId', '" . $profession['childExpenses'] . "')";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				
				return false;
			}
			
			// total
			$sql = "INSERT INTO user_model_total (
				gamer_id, game_id, incomes_actions, incomes_real_estate, incomes_business
				) VALUES ('$gamerId', '$gameId', '0', '0', '0')";			
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			// started dream
			$sql = "INSERT INTO user_model_dream (
							gamer_id, game_id, big_path_position_id, title, price 
							) VALUES ('$gamerId', '$gameId', '-1', '', '')";
			$isSuccess = $dataBaseController->setter($sql);
			if (!$isSuccess) {
				return false;
			}
			
			return true;
		}
		
		public static function read($gamerId, $dataBaseController, $responseCreator) {
			// user_model
			$sql = "SELECT * FROM user_model WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model', $results[0]);
			
			// user_model_actions
			$sql = "SELECT * FROM user_model_actions WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);
			$responseCreator->setData('user_model_actions', createArithmeticReturn($results));
			
			// user_model_real_estate
			$sql = "SELECT * FROM user_model_real_estate WHERE gamer_id = '$gamerId'";
			$results = $dataBaseController->getter($sql);
			$responseCreator->setData('user_model_real_estate', createArithmeticReturn($results));
			
			// user_model_business
			$sql = "SELECT * FROM user_model_business WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);
			$responseCreator->setData('user_model_business', createArithmeticReturn($results));
			
			// user_model_arithmetic_(start)
			$userModelArithmetic = new Schema();
			
			$results = getProperty($gamerId, UserModelProperties::CASH, -1, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::CASH, createArithmeticReturn($results));
			
			$results = getProperty($gamerId, UserModelProperties::EXPENSES, UserModelSubProperties::CHILDREN_EXPENSES, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::EXPENSES . '_' . UserModelSubProperties::CHILDREN_EXPENSES, createArithmeticReturn($results));
			
			$results = getProperty($gamerId, UserModelProperties::EXPENSES, UserModelSubProperties::TOTAL_EXPENSES, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::EXPENSES . '_' . UserModelSubProperties::TOTAL_EXPENSES, createArithmeticReturn($results));
			
			$results = getProperty($gamerId, UserModelProperties::INCOMES, UserModelSubProperties::PASSIVE_INCOMES, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::INCOMES . '_' . UserModelSubProperties::PASSIVE_INCOMES, createArithmeticReturn($results));
			
			$results = getProperty($gamerId, UserModelProperties::INCOMES, UserModelSubProperties::TOTAL_INCOMES, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::INCOMES . '_' . UserModelSubProperties::TOTAL_INCOMES, createArithmeticReturn($results));
			
			$results = getProperty($gamerId, UserModelProperties::MONEY_FLOW, -1, $dataBaseController);
			$userModelArithmetic->setData(UserModelProperties::MONEY_FLOW, createArithmeticReturn($results));
			
			$responseCreator->setData('user_model_arithmetic', $userModelArithmetic->getData());
			// user_model_arithmetic_(end)
			
			// user_model_expenses_const
			$sql = "SELECT 
				taxes, percentagesExpensesOfMortage, expensesByEducationPosition, carExpenses,
				creditCardsExpenses, retailPurchasesExpenses, otherExpenses
				FROM user_model_expenses_const WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_expenses_const error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_expenses_const', $results[0]);
			
			// user_model_incomes_const
			$sql = "SELECT salary FROM user_model_incomes_const WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_incomes_const error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_incomes_const', $results[0]);
			
			// user_model_assets_const
			$sql = "SELECT savings FROM user_model_assets_const WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_assets_const error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_assets_const', $results[0]);
			
			// user_model_credit_liabilities_const
			$sql = "SELECT 
				mortage, educationLoan, carLoan, creditCards, debtForRetailPurchases
				FROM user_model_credit_liabilities_const WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_credit_liabilities_const error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_credit_liabilities_const', $results[0]);
			
			// user_model_child_expenses_const
			$sql = "SELECT value FROM user_model_child_expenses_const WHERE gamer_id = '$gamerId'";			
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_child_expenses_const error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_child_expenses_const', $results[0]);
			
			// user_model_total
			$sql = "SELECT incomes_actions, incomes_real_estate, incomes_business
				FROM user_model_total WHERE gamer_id = '$gamerId'";
			$results = $dataBaseController->getter($sql);			
			if (!$results) {
				$responseCreator->setError('user_model_total error');
				return $responseCreator->getData();
			}
			$responseCreator->setData('user_model_total', $results[0]);
			
			// user_model_buyed_dreams_(start)
			$bigPathCard = new Schema();
			
			$sql = "SELECT * FROM user_model_buyed_dreams WHERE gamer_id = '$gamerId'";
			$results = $dataBaseController->getter($sql);
			$bigPathCard->setData('user_model_buyed_dreams', createArithmeticReturn($results));
			
			$sql = "SELECT * FROM user_model_buyed_business WHERE gamer_id = '$gamerId'";
			$results = $dataBaseController->getter($sql);
			$bigPathCard->setData('user_model_buyed_business', createArithmeticReturn($results));
			
			$sql = "SELECT * FROM user_model_buyed_cash WHERE gamer_id = '$gamerId'";
			$results = $dataBaseController->getter($sql);
			$bigPathCard->setData('user_model_buyed_cash', createArithmeticReturn($results));
			
			$responseCreator->setData('user_model_big_path_card', $bigPathCard->getData());
			// user_model_buyed_dreams_(end)
			
			return $responseCreator->getData();
		}
	}
	
	function createArithmeticReturn($results) {
		return $results ? $results : [];
	}
	
	function getProperty($gamerId, $property, $sub_property, $dataBaseController) {
		$sql = "SELECT id, value, result FROM 
			user_model_arithmetic WHERE gamer_id = '$gamerId' AND 
			property = '$property' AND sub_property = '$sub_property'";
		$results = $dataBaseController->getter($sql);
		
		if (!$results) {
			return null;
		}
		
		return $results;
		
		$schema = new Schema();
		$schema->setData(UserModelProperties::CASH, $results);
		
		return $schema->getData();
	}
?>