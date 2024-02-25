<?php
	class Professions {
		private $professionList = [];
		private $schema = null;

		public function __construct() {
			$this->schema = new Schema();
		}
		
		public function getUsersProfessionList($usersNumber) {
			$result = [];			
			$this->createProfessionList();
			$indexRNDList = RNDCreator::proceed(count($this->professionList) - 1);
			
			for ($index = 0; $index < $usersNumber; $index++) {
				$indexRND = $indexRNDList[$index];
				array_push($result, $this->professionList[$indexRND]);
			}
			
			$this->professionList = [];
			return $result;
		}
		
		private function setProfessionList() {
			array_push($this->professionList, $this->schema->getData());
			$this->schema->clearData();
		}
		
		public function getBankruptedGamerNewProfession($usedProfesionIdList) {			
			$usedIdList = [];
			foreach ($usedProfesionIdList as $item) {
				array_push($usedIdList, $item);
			}
			
			$this->createProfessionList();
			$indexRNDList = RNDCreator::proceed(count($this->professionList) - 1);
			
			$newIndex = -1;
			for ($index = 0; $index < count($indexRNDList); $index++) {
				if (!$this->checkIfProfessionIsUsed($this->professionList[$index]['id'], $usedIdList)) {
					$newIndex = $index;
					break;
				}
			}
			
			return $newIndex === -1 ? null : $this->professionList[$newIndex];
		}
		
		private function checkIfProfessionIsUsed($professionId, $usedIdList) {
			$isPresent = false;
			
			foreach ($usedIdList as $usedId) {
				if ($usedId === $professionId) {
					$isPresent = true;
				}
			}
			
			return $isPresent;
		}
		
		private function createProfessionList() {
			$this->schema->setData('id', 1);
			$this->schema->setData('professionName', 'HR-менеджер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 9500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 9500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 2350);
			$expenses->setData('percentagesExpensesOfMortage', 1330);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 300);
			$expenses->setData('creditCardsExpenses', 660);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 2210);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 6900);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2600);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 400);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 143000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 15000);
			$creditLiabilities->setData('creditCards', 22000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 480);
			
			$this->setProfessionList();
						
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 2);
			$this->schema->setData('professionName', 'Менеджер з агрохолдінгу');
			
			$incomes = new Schema();
			$incomes->setData('salary', 6000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 6000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 1190);
			$expenses->setData('percentagesExpensesOfMortage', 600);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 400);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 160);
			$expenses->setData('otherExpenses', 690);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 3100);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2900);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 800);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 46000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 2000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 250);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 3);
			$this->schema->setData('professionName', 'Психолог');
			
			$incomes = new Schema();
			$incomes->setData('salary', 3100);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 3100);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 600);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 30);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 90);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 710);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1980);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1120);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 400);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 47000);
			$creditLiabilities->setData('educationLoan', 6000);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 3000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 170);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 4);
			$this->schema->setData('professionName', 'Кондитер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 4000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 4000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 610);
			$expenses->setData('percentagesExpensesOfMortage', 500);
			$expenses->setData('expensesByEducationPosition', 60);
			$expenses->setData('carExpenses', 120);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 500);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1900);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2100);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 380);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 65000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 6000);
			$creditLiabilities->setData('creditCards', 3000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 240);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 5);
			$this->schema->setData('professionName', 'Хендмейдер на дауншифтінгу');
			
			$incomes = new Schema();
			$incomes->setData('salary', 4000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 4000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 600);
			$expenses->setData('percentagesExpensesOfMortage', 500);
			$expenses->setData('expensesByEducationPosition', 60);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 90);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 710);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 2100);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1900);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 450);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 50000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 3000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 180);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 6);
			$this->schema->setData('professionName', 'Трейдер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 9500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 9500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 2350);
			$expenses->setData('percentagesExpensesOfMortage', 1330);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 300);
			$expenses->setData('creditCardsExpenses', 660);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 2210);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 6900);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2600);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 400);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 143000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 15000);
			$creditLiabilities->setData('creditCards', 22000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 480);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 7);
			$this->schema->setData('professionName', 'Діджей');
			
			$incomes = new Schema();
			$incomes->setData('salary', 1600);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 1600);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 280);
			$expenses->setData('percentagesExpensesOfMortage', 200);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 60);
			$expenses->setData('creditCardsExpenses', 50);
			$expenses->setData('retailPurchasesExpenses', 60);
			$expenses->setData('otherExpenses', 300);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 95);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 650);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 550);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 20000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 4000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 70);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 8);
			$this->schema->setData('professionName', 'Лікар');
			
			$incomes = new Schema();
			$incomes->setData('salary', 2500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 2500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 460);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 80);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 570);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1620);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 880);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 750);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 38000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 4000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 140);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 9);
			$this->schema->setData('professionName', 'Біоінженер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 3000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 3000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 580);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 690);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1880);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1120);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 520);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 46000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 160);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 10);
			$this->schema->setData('professionName', 'Бортпровідник');
			
			$incomes = new Schema();
			$incomes->setData('salary', 2500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 2500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 460);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 80);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 570);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1620);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 880);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 710);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 38000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 4000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 140);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 11);
			$this->schema->setData('professionName', 'Фромажьє');
			
			$incomes = new Schema();
			$incomes->setData('salary', 3500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 3500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 620);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 30);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 90);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 710);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 2000);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1500);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 430);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 47000);
			$creditLiabilities->setData('educationLoan', 6000);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 3000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 170);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 12);
			$this->schema->setData('professionName', 'Ігротренер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 5900);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 5900);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 690);
			$expenses->setData('percentagesExpensesOfMortage', 400);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 0);
			$expenses->setData('otherExpenses', 690);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1940);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 3960);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 800);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 46000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 0);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 250);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 13);
			$this->schema->setData('professionName', 'Бізнес-аналітик');
			
			$incomes = new Schema();
			$incomes->setData('salary', 4600);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 4600);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 910);
			$expenses->setData('percentagesExpensesOfMortage', 700);
			$expenses->setData('expensesByEducationPosition', 60);
			$expenses->setData('carExpenses', 120);
			$expenses->setData('creditCardsExpenses', 90);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 1000);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 2930);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1670);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 400);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 75000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 6000);
			$creditLiabilities->setData('creditCards', 32000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 240);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 14);
			$this->schema->setData('professionName', 'ІТ-директор');
			
			$incomes = new Schema();
			$incomes->setData('salary', 7500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 7500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 1830);
			$expenses->setData('percentagesExpensesOfMortage', 1100);
			$expenses->setData('expensesByEducationPosition', 390);
			$expenses->setData('carExpenses', 220);
			$expenses->setData('creditCardsExpenses', 180);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 1650);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 5420);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2080);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 670);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 115000);
			$creditLiabilities->setData('educationLoan', 78000);
			$creditLiabilities->setData('carLoan', 11000);
			$creditLiabilities->setData('creditCards', 6000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 3800);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 15);
			$this->schema->setData('professionName', 'Грумер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 5000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 5000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 750);
			$expenses->setData('percentagesExpensesOfMortage', 600);
			$expenses->setData('expensesByEducationPosition', 50);
			$expenses->setData('carExpenses', 140);
			$expenses->setData('creditCardsExpenses', 120);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 1090);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 2800);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2200);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 450);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 75000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 7000);
			$creditLiabilities->setData('creditCards', 4000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 250);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 16);
			$this->schema->setData('professionName', 'Архітектор');
			
			$incomes = new Schema();
			$incomes->setData('salary', 13200);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 13200);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 3420);
			$expenses->setData('percentagesExpensesOfMortage', 1900);
			$expenses->setData('expensesByEducationPosition', 750);
			$expenses->setData('carExpenses', 380);
			$expenses->setData('creditCardsExpenses', 270);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 2880);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 9650);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 3550);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 450);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 202000);
			$creditLiabilities->setData('educationLoan', 150000);
			$creditLiabilities->setData('carLoan', 19000);
			$creditLiabilities->setData('creditCards', 9000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 640);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 17);
			$this->schema->setData('professionName', 'Адвокат');
			
			$incomes = new Schema();
			$incomes->setData('salary', 7500);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 7500);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 1830);
			$expenses->setData('percentagesExpensesOfMortage', 1100);
			$expenses->setData('expensesByEducationPosition', 390);
			$expenses->setData('carExpenses', 220);
			$expenses->setData('creditCardsExpenses', 180);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 1650);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 5420);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 2080);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 400);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 115000);
			$creditLiabilities->setData('educationLoan', 78000);
			$creditLiabilities->setData('carLoan', 11000);
			$creditLiabilities->setData('creditCards', 6000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 380);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 18);
			$this->schema->setData('professionName', 'Спічрайтер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 3300);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 3300);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 630);
			$expenses->setData('percentagesExpensesOfMortage', 500);
			$expenses->setData('expensesByEducationPosition', 60);
			$expenses->setData('carExpenses', 100);
			$expenses->setData('creditCardsExpenses', 90);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 760);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 2190);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1110);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 450);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 50000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 5000);
			$creditLiabilities->setData('creditCards', 3000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 180);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 19);
			$this->schema->setData('professionName', 'Президент корпорації');
			
			$incomes = new Schema();
			$incomes->setData('salary', 10000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 10000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 300);
			$expenses->setData('percentagesExpensesOfMortage', 1000);
			$expenses->setData('expensesByEducationPosition', 1000);
			$expenses->setData('carExpenses', 400);
			$expenses->setData('creditCardsExpenses', 300);
			$expenses->setData('retailPurchasesExpenses', 500);
			$expenses->setData('otherExpenses', 300);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 6500);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 3500);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 1000);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 0);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 20000);
			$creditLiabilities->setData('creditCards', 0);
			$creditLiabilities->setData('debtForRetailPurchases', 0);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 500);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 20);
			$this->schema->setData('professionName', 'Блогер');
			
			$incomes = new Schema();
			$incomes->setData('salary', 2000);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 2000);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 360);
			$expenses->setData('percentagesExpensesOfMortage', 300);
			$expenses->setData('expensesByEducationPosition', 0);
			$expenses->setData('carExpenses', 60);
			$expenses->setData('creditCardsExpenses', 60);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 450);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 1280);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 720);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 680);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 31000);
			$creditLiabilities->setData('educationLoan', 0);
			$creditLiabilities->setData('carLoan', 3000);
			$creditLiabilities->setData('creditCards', 2000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 110);
			
			$this->setProfessionList();
			
			// --------------------------------------------------------------
			
			$this->schema->setData('id', 21);
			$this->schema->setData('professionName', 'Ресторатор');
			
			$incomes = new Schema();
			$incomes->setData('salary', 4900);
			$incomes->setData('actions', 0);
			$incomes->setData('realEstate', 0);
			$incomes->setData('business', 0);
			$incomes->setData('passiveIncome', 0);
			$incomes->setData('totalIncomes', 4900);			
			$this->schema->setData('incomes', $incomes->getData());
			
			$expenses = new Schema();
			$expenses->setData('taxes', 1050);
			$expenses->setData('percentagesExpensesOfMortage', 700);
			$expenses->setData('expensesByEducationPosition', 60);
			$expenses->setData('carExpenses', 140);
			$expenses->setData('creditCardsExpenses', 120);
			$expenses->setData('retailPurchasesExpenses', 50);
			$expenses->setData('otherExpenses', 1090);
			$expenses->setData('childrenExpenses', 0);
			$expenses->setData('totalExpenses', 3210);
			$this->schema->setData('expenses', $expenses->getData());
			
			$this->schema->setData('moneyFlow', 1690);
			$this->schema->setData('cash', 0);
			
			$assets = new Schema();
			$assets->setData('savings', 410);
			$this->schema->setData('assets', $assets->getData());
			
			$creditLiabilities = new Schema();
			$creditLiabilities->setData('mortage', 75000);
			$creditLiabilities->setData('educationLoan', 12000);
			$creditLiabilities->setData('carLoan', 7000);
			$creditLiabilities->setData('creditCards', 4000);
			$creditLiabilities->setData('debtForRetailPurchases', 1000);
			$this->schema->setData('creditLiabilities', $creditLiabilities->getData());
			
			$this->schema->setData('childExpenses', 250);
			
			$this->setProfessionList();
		}
	}
?>