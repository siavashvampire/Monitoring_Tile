<?php

lang::addToLangfile('wallet');
return [
	'info' => [
		'name' => rlang('walletApp'),
		'description' => rlang('walletAppDescription'),
		'version' => '1.0.0.0',
		'author' => 'Erfan Ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	] ,
	'db' => [
		'wallet_action' => [
			'fields' => [
				'actionId' => 'INT NOT NULL AUTO_INCREMENT',
				'userId' => 'INT NULL DEFAULT NULL',
				'invoiceId' => 'INT NULL DEFAULT NULL',
				'status' => 'enum(\'deposit\',\'withdrawRequest\',\'withdrawAccept\',\'withdrawReject\',\'pending\') COLLATE utf8_persian_ci DEFAULT NULL',
				'price' => 'VARCHAR(65) NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'dateAction' => 'DATE NULL DEFAULT NULL',
				'timeAction' => 'TIME NULL DEFAULT NULL',
				'description' => 'TEXT NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'ip' => 'varchar(36) COLLATE utf8_persian_ci DEFAULT NULL',
			],
			'KEY' => [
				'userId',
				'invoiceId',
			],
			'PRIMARY KEY' => [
				'actionId'
			],
			'REFERENCES' => [
				'userId' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ],
				'invoiceId' => [ 'table' => 'invoice' , 'column' => 'invoiceId' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ]
			]
		] ,
		'user_wallet' => [
			'fields' => [
				'userId' => 'INT NOT NULL',
				'affiliatedId' => 'INT NULL DEFAULT NULL',
				'wallet' => 'VARCHAR(65) NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'bankFName' => 'VARCHAR(65) NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'bankLName' => 'VARCHAR(65) NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'bankName' => 'VARCHAR(65) NULL COLLATE utf8_persian_ci DEFAULT NULL',
				'shabaNumber' => 'varchar(36) COLLATE utf8_persian_ci DEFAULT NULL',
			],
			'KEY' => [
				'userId',
				'affiliatedId',
			],
			'PRIMARY KEY' => [
				'userId'
			],
			'REFERENCES' => [
				'userId' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ],
				'affiliatedId' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ],
			]
		]
	] ,
	'configuration' => [
		'canDeposit' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('canDeposit'),
			'description' => '',
			'value' => 'yes',
			'valueDe' =>  [ 'yes' , 'no' ]
		],
		'canWithDraw' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('canWithDraw'),
			'description' => rlang('canWithDrawDescription'),
			'value' => 'yes',
			'valueDe' =>  [ 'yes' , 'no' ]
		],
		'lowDepositMoney' => [
			'type' => 'number',
			'status' => 'required',
			'title' => rlang('lowDepositMoney'),
			'description' => rlang('lowDepositMoneyDescription'),
			'value' => '1000',
			'valueDe' => ''
		],
		'maxDepositMoney' => [
			'type' => 'number',
			'status' => 'required',
			'title' => rlang('maxDepositMoney'),
			'description' => rlang('maxDepositMoneyDescription'),
			'value' => '1000',
			'valueDe' => ''
		],
		'lowWithdrawMoney' => [
			'type' => 'number',
			'status' => 'required',
			'title' => rlang('lowWithdrawMoney'),
			'description' => rlang('lowWithdrawMoneyDescription'),
			'value' => '1000',
			'valueDe' => ''
		],
		'canAffiliate' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('canAffiliate'),
			'description' => rlang('canAffiliateDescription'),
			'value' => 'yes',
			'valueDe' =>  [ 'yes' , 'no' ]
		],
	]
];