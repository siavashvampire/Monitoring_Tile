<?php

return [
	'info' => [
		'name' => rlang('meliPayamkSmsName'),
		'description' => rlang('meliPayamkSmsDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'username' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('smsUsernameMeliPayamk'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'password' => [
			'type' => 'password',
			'status' => 'required',
			'title' => rlang('smsPasswordMeliPayamk'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'from' => [
			'type' => 'number',
			'status' => 'required',
			'title' => rlang('smsNumberMeliPayamk'),
			'description' => '',
			'value' => '0',
			'valueDe' => [
			],
		],
		'sign' => [
			'type' => 'textarea',
			'status' => '',
			'title' => rlang('smsSignMeliPayamk'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		]
	]
];