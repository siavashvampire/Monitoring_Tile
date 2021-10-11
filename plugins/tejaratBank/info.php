<?php
return [
	'info' => [
		'name' => rlang('gateWayTejarat'),
		'description' => rlang('gateWayTejaratDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'MerchantIdTejarat' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('MerchantId'),
			'description' => rlang('MerchantIdDes'),
			'value' => '',
			'valueDe' => [
			],
		],
		'Sha1KeyTejarat' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('Sha1Key'),
			'description' => rlang('Sha1KeyDes'),
			'value' => '',
			'valueDe' => [
			],
		],
		'gateWayNameTejarat' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('gateWayName'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		]
	]
];