<?php
return [
	'info' => [
		'name' => 'Picture IT',
		'description' => 'Controlling Table',
		'version' => '1.0.0.0',
		'author' => 'Siavash Sepahi',
		'support' => '09379206248',
	],
	'configuration' => [
	],
	'db' => [
		'devices' => [
			'fields' => [
				'id'     => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label'  => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'port'   => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'Active' => "TINYINT NOT NULL DEFAULT '0'",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
				'id'
			],
			'REFERENCES' => [
			]
		],	
        'quotes' => [
			'fields' => [
				'id'          => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label'       => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'device_id'   => "int(11) NOT NULL",
				'Send_Time'   => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
				'id'
			],
			'REFERENCES' => [
			]
		],
	]
];