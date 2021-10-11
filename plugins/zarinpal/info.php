<?php
return [
	'info' => [
		'name' => rlang('gateWayZarinPal'),
		'description' => 'zarinpal gateWay for payment cms',
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'MerchantID' => [
			'type' => 'text',
			'status' => 'required',
			'title' => 'MerchantID',
			'description' => '',
			'value' => '',
			'valueDe' => []
		]
	]
];