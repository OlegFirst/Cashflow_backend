<?php
	abstract class QueryElements {
		const LOGIN = 'login';
		const PASSWORD = 'password';
		const GET_USER_DATA = 'GET_USER_DATA';
		const GET_GAME_OWNERS_DATA = 'get-game-owners';
		
		const CREATE_NEW_GAME = 'create-new-game';
		const EDIT_GAME = 'edit-game';
		const GET_GAMES = 'get-games';
		const CREATE_NEW_GAME_OWNER = 'create-new-game-owner';
		const REMOVE_GAME_OWNER = 'remove-game-owner';
		const REMOVE_GAME = 'remove-game';		
		const GAME_PROCESSING = 'processing-game';
		
		const GAMER_BANKRUPT = 'gamer-bankrupt';
	}
	
	abstract class GameQueryElements {
		const GAME_PREPARATION = 'game-preparation';
		const GAME_OWNER_CHECK_MAKE_NEXT_TURN = 'game-check-make-next-turn';
		const GAME_OWNER_MAKE_NEXT_TURN = 'game-make-next-turn';
		
		const GAME_USER_MODEL_INSERT = 'user_model-insert';
		const GAME_USER_MODEL_UPDATE = 'user_model-update';
		const GAME_USER_MODEL_REMOVE = 'user_model-remove';		
		const SET_FISHKA_POSITION ='set-fishka-position';
		const GAME_OWNER_SET_CHARITY_TURNS_LEFT ='set-charity-turns-left';
		const GAME_OWNER_GET_MARKET = 'game-get-market';
		const GAME_OWNER_MOVE_GAMER_TO_PATH = 'game-move-to-path';
		const GAMER_START_TURN = 'gamer-start-turn';
		const GAMER_END_TURN = 'gamer-end-turn';
		const WAITING_CONNECTION = 'waiting-connection';
		const GAME_OWNER_SEND_AGREEMENT_TO_GAMER = 'send-agreement-to-gamer';
		const GAME_OWNER_SEND_COMMON_AGREEMENT_TO_GAMER = 'send-common-agreement-to-gamer';
		const GAME_OWNER_REMOVE_AGREEMENT_FROM_GAMER = 'game-remove-agreement-from-gamer';
		const GAMER_GET_AGREEMENT = 'gamer-get-agreement';
		const GAMER_REMOVE_AGREEMENT = 'gamer-remove-agreement';
		const GAMER_SELL_AGREEMENT = 'gamer-sell-agreement';
		const GAMER_BUY_AGREEMENT = 'gamer-buy-agreement';
		const GAMER_GET_DREAM = 'get-dream';
		const GAMER_SET_DREAM = 'set-dream';
		const GAME_OWNER_GET_MONEY_IN_THE_WIND = 'get-m-w';
		const GAME_OWNER_SET_BANKRUPT = 'set-gamer-bankrupt';
	}
	
	abstract class GameProcessingModes {
		const START = 1;
		const COMPLETE = 2;
		const CANCEL = 0;
	}
	
	abstract class UserModelProperties {
		const INCOMES = 'incomes';
		const EXPENSES = 'expenses';
		const MONEY_FLOW = 'money_flow';
		const CASH = 'cash';
		const BANK_LOAN = 'bank_loan';
	}
	
	abstract class UserModelSubProperties {
		const PASSIVE_INCOMES = 'passive_incomes';
		const TOTAL_INCOMES = 'total_incomes';
		const CHILDREN_EXPENSES = 'children_expenses';
		const TOTAL_EXPENSES = 'total_expenses';
	}
	
	abstract class CardTypes {
		const SMALL_AGREEMENT = 'small_agreement';
		const BIG_AGREEMENT = 'big_agreement';
		const MARKET = 'market';
		const MONEY_IN_THE_WIND = 'money_in_the_wind';
		const ALL_TYPES = 'all_types';
	}
	
	abstract class ProfessionCardTypes {
		const ACTIONS = 'ACTIONS';
		const REAL_ESTATE = 'REAL_ESTATE';
		const BUSINESS = 'BUSINESS';
		const ARITHMETIC = 'ARITHMETIC';
		const BUYED_DREAMS = 'BUYED_DREAMS';
		const BUYED_BUSINESS = 'BUYED_BUSINESS';
		const BUYED_CASH = 'BUYED_CASH';
	}
	
	abstract class GameCases {
		const BANKRUPT_CASH_FLOW_VALUE = 300;
	}
?>