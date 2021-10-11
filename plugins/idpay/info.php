<?php
return [
	'info' => [
		'name' => rlang('gateWayIdPay'),
		'description' => rlang('gateWayIdPayDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'apiKey' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('apiKey'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'sandBox' => [
			'type' => 'checkbox',
			'status' => 'required',
			'title' => rlang('apiKey'),
			'description' => rlang('sandBoxDescription'),
			'value' => rlang('sandBoxOn'),
			'valueDe' => [
				rlang('sandBoxOn')
			],
		],
		'gateWayName' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('gateWayName'),
			'description' => '',
			'value' => 'idPay',
			'valueDe' => [
			],
		]
	]
];