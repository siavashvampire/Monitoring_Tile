<?php
return [
	'info' => [
		'name' => 'core',
		'description' => 'core',
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	] ,
//	'configuration' => [
//		'site_name' => [
//			'type' => 'text',
//			'status' => 'required',
//			'title' => ' esme site :',
//			'description' => ' esme site be tore kamel',
//			'value' => 'my name is',
//			'valueDe' => [
//				'12',
//				'13',
//				'14'
//			],
//		]
//	],
	'db' => [
		'apps_link' => [
			'fields' => [
				'apps_linkId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'link' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'app' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
				'apps_linkId'
			],
			'REFERENCES' => [
			]
		],
		'field' => [
			'fields' => [
				'fieldId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'type' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'title' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'description' => "text COLLATE utf8_persian_ci",
				'values' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'regex' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'serviceId' => "int(11) DEFAULT NULL",
				'serviceType' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'status' => "enum('required','visible','invisible','admin') COLLATE utf8_persian_ci DEFAULT 'visible'",
				'orderNumber' => "TINYINT NULL DEFAULT '0'",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
				'fieldId'
			],
			'REFERENCES' => [
			]
		],
		'fieldvalue' => [
			'fields' => [
				'fieldId' => 'INT(11) DEFAULT NULL',
				'objectId' => 'INT(11) DEFAULT NULL',
				'objectType' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'value' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
			],
			'KEY' => [
				'objectId',
				'fieldId'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
				'fieldId' => [ 'table' => 'field' , 'column' => 'fieldId' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ]
			]
		],
		'configuration' => [
			'fields' => [
				'keyWord' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'app' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'value' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
			]
		]
	]
];